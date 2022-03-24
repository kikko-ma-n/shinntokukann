<?php
//定数の定義
require __DIR__ . '/pass.php';

const HEAVEN = array('甲', '乙', '丙', '丁', '戊', '己', '庚', '辛', '壬', '癸');
const ZODIAC = array('子', '丑', '寅', '卯', '辰', '巳', '午', '未', '申', '酉', '戌', '亥');
const FIVE_LINE = array('木', '火', '土', '金', '水');


//性別の確認
function genderChecked($post_gender) {
  if($post_gender == 0) {
    echo '<input type="radio" name="gender" value="0" checked>男性 ';
    echo '<input type="radio" name="gender" value="1" >女性 ';
  } else {
    echo '<input type="radio" name="gender" value="0" >男性';
    echo '<input type="radio" name="gender" value="1" checked>女性';
  }
}

// MySQL への接続
function connect() {
    try{
        $pdo = new PDO(DNS, USER, PASS);
        // echo '接続成功！';
        return $pdo;
      } catch (PDOException $e) {
        echo '接続失敗';
        echo $e->getMessage();
        exit();
      }
}

//数値→文字への変換(天干・地支)
function num_char(array $num) {
  $char = [];
  for($i = 0; $i < count($num); $i+=2) {
    array_push($char, HEAVEN[$num[$i]], ZODIAC[$num[$i+1]]);
  }
  return $char;
}

//数値→文字への変換(五行)
function five_char(array $array) {
  $five = ['木', '火', '土', '金', '水'];
  $result = [];
  for($i = 0; $i < count($array); $i++) {
    array_push($result, $five[$array[$i]]);
  }
  return $result;
}

//Personalクラスの定義
class Personal {
    //プロパティ
    //パブリックプロパティ
    public $pillars;  //命式(配列)
    public $pillars_five; //命式の五行
    public $pillars_ten;      //通変星(配列)
    public $pillars_twelve;   //十二長生(配列)
    public $zokan;    //蔵干(2次元配列)
    public $god;      //神煞(２次元配列)
    public $fate;     //大運(配列)
    public $fate_five;//大運の五行
    public $fate_ten; //大運の通変星
    public $fate_twelve; //大運の十二長生
    public $five_main;  //五行の頭(数値)
    public $five_line; //五行のバランス
    public $up_year;  //立運年
    public $up_month; //立運月
    // public $up_date;  //立運日

    //プライベートプロパティ
    public $year;   //年
    private $month;  //月
    private $date;   //日
    private $time;   //時間
    private $hour;   //時
    private $minute; //分
    private $gender; //性別
    private $days;   //日数

    //コンストラクタ
    function __construct($year, $month, $day, $time, $gender)
    {
      //プライベートプロパティの初期化
      $this->year = $year;
      $this->month = $month;
      $this->date = $day;
      $this->time = str_replace(':', '', $time);
      if(empty($time) == 0) {
        $this->hour = explode(':', $time)[0] * 1;
        $this->minute = explode(':', $time)[1] * 1;
      }
      $this->gender = $gender;
      $str_date = "$year-$month-$day";
      if($year < 1941) {
        $this->days = (strtotime('1942-01-01') - strtotime($str_date)) / (60 * 60 * 24);
      } else {
        $this->days = (strtotime($str_date) - strtotime('1942-01-01')) / (60 * 60 * 24);
      }

      //パブリックプロパティの初期化
      $this->pillars = num_char($this->pillars());
      $this->pillars_five = five_char($this->five($this->pillars()));
      $this->pillars_ten = $this->ten($this->pillars());
      $this->pillars_twelve = $this->twelve($this->pillars());
      $this->fate = num_char($this->fate());
      $this->fate_five = five_char($this->five($this->fate()));
      $this->fate_ten = $this->ten($this->fate());
      $this->fate_twelve = $this->twelve($this->fate());
      $this->five_line = $this->five_line();
      $this->five_main = $this->five($this->pillars())[4];
      for($i = 0; $i < 10; $i++) {
        $this->up_year[$i] = $this->up_fate()[0] + 10 * $i;
      }
      $this->up_month = $this->up_fate()[1] * 1;
      // $this->up_date = $this->up_fate()[2] * 1;
      $this->zokan = $this->zokan();
      $this->god = $this->god();
    }

    //メソッド
    //生年月日を表示する。
    public function birthday() {
      if(empty($this->time)) {
        echo $this->year . '年'. $this->month . '月'. $this->date . '日生まれの';
        if($this->gender == 0) {
          echo '男性';
        } else {
          echo '女性';
        }
      } else {
        echo $this->year . '年'. $this->month . '月'. $this->date . '日'. $this->hour. '時'. $this->minute .'分生まれの';
        if($this->gender == 0) {
          echo '男性';
        } else {
          echo '女性';
        }
      }
    }

    //節季を求める関数
    private function division() {
      if (empty($this->time)) {
        $division = ($this->year * 100000000) + ($this->month * 1000000) + ($this->date * 10000);
      } else {
        $division = ($this->year * 100000000) + ($this->month * 1000000) + ($this->date * 10000) + $this->time;
      }
      return $division;
    }

    //命式を求める(数値)
    private function pillars() {

      //年柱・月柱を求める
      $division = $this->division();
      $query = "SELECT * FROM divisions WHERE division >'" . $division . "' ORDER BY division LIMIT 1;";
        //MySQL への接続
        $pdo = connect();
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();
        unset($pdo);
        //MySQL から切断
      $month = [
        (int) $result[0]['yHeaven'],
        (int) $result[0]['yZodiac'],
        (int) $result[0]['mHeaven'],
        (int) $result[0]['mZodiac']
      ];

      //日柱を求める
      if($this->time < 2300) {
        $heaven = ($this->days) % 10;
        $zodiac = ($this->days + 2) % 12;
      } else {
        $heaven = ($this->days + 1) % 10;
        $zodiac = ($this->days + 3) % 12;
      }
      $date = [
        $heaven,
        $zodiac
      ];

      //時柱を求める
      if(empty($this->time)) {
        $time = [];
      } else {
        if ($this->time < 2300){
          $zodiac = (($this->time + 100) / 200) % 12;
          $heaven = ((((($this->days) % 10) % 5) * 2) + $zodiac) % 10;
        } else {
          $zodiac = 0;
          $heaven = ((($this->days + 1) % 10) % 5) * 2;
        }
        $time = [
          $heaven,
          $zodiac
        ];
      }

      $result = array_merge($month, $date, $time);
      return $result;

    }

    //大運を求める
    private function fate() {
      $result = [];
      $heaven = $this->pillars()[2];
      $zodiac = $this->pillars()[3];
      if((($this->gender + $this->pillars()[0]) % 2) == 0) {
        for($i = 0; $i < 10; $i++) {
          array_push($result, ($heaven+$i)%10, ($zodiac+$i)%12 );
        }
      } else {
        for($i = 0; $i < 10; $i++) {
          array_push($result, ($heaven-$i+10)%10, ($zodiac-$i+12)%12 );
        }
      };
      return $result;
    }

    //五行を求める(数値)
    private function five(array $array) {
      $result = [];
      $five_zodiac = [4, 2, 0, 0, 2, 1, 1, 2, 3, 3, 2, 4];
      for($i = 0; $i < count($array); $i++) {
        if($i % 2 == 0) {
          array_push($result, floor($array[$i] / 2));
        } else {
          array_push($result, $five_zodiac[$array[$i]]);
        }
      }
      return $result;
    }

    //五行のバランスを求める
    private function five_line() {
      $result = [0, 0, 0, 0, 0];
      $five = $this->five($this->pillars());
      for($i = 0; $i < count($this->pillars()); $i++) {
        $result[$five[$i]]++;
      }
      return $result;
    }

    //立命年月日を求める
    private function up_fate() {
      if((($this->gender + $this->pillars()[0]) % 2) == 0) {
        $division = $this->division();
        $query = "SELECT * FROM divisions WHERE division >'" . $division . "' ORDER BY division LIMIT 1;";
          //MySQL への接続
          $pdo = connect();
          $stmt = $pdo->prepare($query);
          $stmt->execute();
          $result = $stmt->fetchAll();
          unset($pdo);
          //MySQL から切断
        $diff = (strtoTime($result[0]['division']) - (strtotime($division))) / (60 * 60 * 24);
        $days = floor($diff); //日
        $time = floor(($diff - $days) * 24 / 2); //刻
        $upYear = floor($days / 3);
        $upMonth = (($days % 3) * 4) + floor(($time * 10) / 30);
        $upDate = ($time * 10) % 30;
        $upFate = date('Y-m-d', strtotime($division. "+$upYear year". "+$upMonth month". "+$upDate day"));
      } else {
        $division = $this->division();
        $query = "SELECT * FROM divisions WHERE division <'" . $division . "' ORDER BY division DESC LIMIT 1;";
          //MySQL への接続
          $pdo = connect();
          $stmt = $pdo->prepare($query);
          $stmt->execute();
          $result = $stmt->fetchAll();
          unset($pdo);
          //MySQL から切断
        $diff = (strtotime($division) - strtoTime($result[0]['division'])) / (60 * 60 * 24);
        $days = floor($diff); //日
        $time = ceil(($diff - $days) * 24 / 2); //刻
        $upYear = floor($days / 3);
        $upMonth = (($days % 3) * 4) + floor(($time * 10) / 30);
        $upDate = ($time * 10) % 30;
        $upFate = date('Y-m-d', strtotime($division. "+$upYear year". "+$upMonth month". "+$upDate day"));
      };
      // echo $upFate . '|';
      // $result = floor(($upFate - floor($this->division() / 10000)) / 10000);
      $result = explode('-', $upFate);
      // echo $upFate . '|';
      return $result;
    }

    //蔵干を求める
    private function zokan() {
      $result = [];
      for($i = 1; $i < count($this->pillars()); $i+=2) {
        switch ($this->pillars()[$i]) { //蔵干
          case 0:
            $array = ['癸'];
            array_push($result, $array);
            break;
          case 1:
            $array = ['己', '癸', '辛'];
            array_push($result, $array);
            break;
          case 2:
            $array = ['甲', '丙', '戊'];
            array_push($result, $array);
            break;
          case 3:
            $array = ['乙'];
            array_push($result, $array);
            break;
          case 4:
            $array = ['戊', '乙', '癸'];
            array_push($result, $array);
            break;
          case 5:
            $array = ['丙', '庚', '戊'];
            array_push($result, $array);
            break;
          case 6:
            $array = ['丁', '己'];
            array_push($result, $array);
            break;
          case 7:
            $array = ['己', '丁', '乙'];
            array_push($result, $array);
            break;
          case 8:
            $array = ['庚', '戊', '壬'];
            array_push($result, $array);
            break;
          case 9:
            $array = ['辛'];
            array_push($result, $array);
            break;
          case 10:
            $array = ['戊', '辛', '丁'];
            array_push($result, $array);
            break;
          case 11:
            $array = ['壬', '甲'];
            array_push($result, $array);
            break;
        }
      }
      return $result;
    }

    //十二長生を求める。
    private function twelve($array) {
      $twelve = ['長生', '沐浴', '冠帯', '臨官', '帝旺', '衰', '病', '死', '墓', '絶', '胎', '養'];
      $twelve_char = [];
      $result = [];
      switch($this->pillars()[4]) { //十二長生
        case 0:
          for($i = 0; $i < 12; $i++) {
            array_push($twelve_char, $twelve[($i + 1) % 12] );
          }
          break;
        case 1:
          for($i = 0; $i < 12; $i++) {
            array_push($twelve_char, $twelve[(18 - $i) % 12] );
          }
          break;
        case 2:
        case 4:
          for($i = 0; $i < 12; $i++) {
            array_push($twelve_char, $twelve[($i + 10) % 12] );
          }
          break;
        case 3:
        case 5:
          for($i = 0; $i < 12; $i++) {
            array_push($twelve_char, $twelve[(21 - $i) % 12] );
          }
          break;
        case 6:
          for($i = 0; $i < 12; $i++) {
            array_push($twelve_char, $twelve[($i + 7) % 12] );
          }
          break;
        case 7:
          for($i = 0; $i < 12; $i++) {
            array_push($twelve_char, $twelve[(24 - $i) % 12] );
          }
          break;
        case 8:
          for($i = 0; $i < 12; $i++) {
            array_push($twelve_char, $twelve[($i + 4) % 12] );
          }
          break;
        case 9:
          for($i = 0; $i < 12; $i++) {
            array_push($twelve_char, $twelve[(15 - $i) % 12] );
          }
          break;
      }
      // var_dump($twelve_char);
      for($i = 1; $i < count($array); $i+=2) {
        array_push($result, $twelve_char[$array[$i]]);
      }
      return $result;
    }

    //通変星(十神)を求める
    private function ten($array) {
      $ten_god = ['比肩', '劫財', '食神', '傷官', '偏財', '正財', '偏官', '正官', '偏印', '正印'];
      $table = [ //$table[日主][天干]
        [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
        [1, 0, 3, 2, 5, 4, 7, 6, 9, 8],
        [8, 9, 0, 1, 2, 3, 4, 5, 6, 7],
        [9, 8, 1, 0, 3, 2, 5, 4, 7, 6],
        [6, 7, 8, 9, 0, 1, 2, 3, 4, 5],
        [7, 6, 9, 8, 1, 0, 3, 2, 5, 4],
        [4, 5, 6, 7, 8, 9, 0, 1, 2, 3],
        [5, 6, 7, 6, 9, 8, 1, 0, 3, 2],
        [2, 3, 4, 5, 6, 7, 8, 9, 0, 1],
        [3, 2, 5, 4, 7, 6, 9, 8, 1, 0]
      ];
      $result = [];
      for($i = 0; $i < count($array); $i+=2) {
        $point = $table[$this->pillars()[4]][$array[$i]];
        array_push($result, $ten_god[$point]);
      }
      return $result;
    }

    //神煞を求める
    //魁罡は身強・身弱の判断がない
    private function god() {

      //①年干・日干から年、月、日、時の地支を見る神煞
      $result_1 = [];
      $god_1 = ['貴', '貴', '文', '学', '禄', '羊', '紅'];
      $table_1 = [ //神煞 = array_keys(array_colum($table, 年干・日干), 地支)
        [1, 0, 11, 9, 1, 0, 1, 2, 5, 5],
        [7, 8, 9, 11, 7, 8, 7, 6, 3, 3],
        [5, 6, 8, 9, 8, 9, 11, 0, 2, 3],
        [11, 6, 2, 9, 2, 9, 5, 0, 8, 3],
        [2, 3, 5, 6, 5, 6, 8, 9, 11, 0],
        [3, 4, 6, 7, 6, 7, 9, 10, 0, 1],
        [6, 6, 2, 7, 4, 4, 10, 9, 0, 8]
      ];

      for($i = 0; $i < count($this->pillars()); $i++) {
        if($i % 2 == 1) {
          $array = array_merge(
            array_keys(array_column($table_1, $this->pillars()[0]), $this->pillars()[$i]),
            array_keys(array_column($table_1, $this->pillars()[4]), $this->pillars()[$i]));
          array_push($result_1, $array);
        } else {
          $array = [];
          array_push($result_1, $array);
        }
      }
      for($i = 0; $i < count($result_1); $i++) {
        for($j = 0; $j < count($result_1[$i]); $j++) {
          $result_1[$i][$j] = $god_1[$result_1[$i][$j]];
        }
        // print_r($result_1[$i]);
        // echo nl2br(PHP_EOL);
      }
      // echo '-----------------' . nl2br(PHP_EOL);

      //②年支・日支から年、月、時の地支を見る神煞
      $result_2 = [];
      $god_2 = ['将', '華', '驛', '劫', '亡', '桃'];
      $table_2 = [ //神煞 = array_keys(array_colum($table_2, 年支・日支), 地支)
        [0, 9, 6, 3, 0, 9, 6, 3, 0, 9, 6, 3],
        [4, 1, 10, 7, 4, 1, 10, 7, 4, 1, 10, 7],
        [2, 11, 8, 5, 2, 11, 8, 5, 2, 11, 8, 5],
        [5, 2, 11, 8, 5, 2, 11, 8, 5, 2, 11, 8],
        [11, 8, 5, 2, 11, 8, 5, 2, 11, 8, 5, 2],
        [9, 6, 3, 0, 9, 6, 3, 0, 9, 6, 3, 0]
      ];

      for($i = 0; $i < count($this->pillars()); $i++) {
        if($i % 2 == 1) {
          if($i == 1) {
            $array = array_keys(array_column($table_2, $this->pillars()[5]), $this->pillars()[$i]);
            array_push($result_2, $array);
          } else if($i == 5) {
            $array = array_keys(array_column($table_2, $this->pillars()[1]), $this->pillars()[$i]);
            array_push($result_2, $array);
          } else {
            $array = array_merge(
              array_keys(array_column($table_2, $this->pillars()[1]), $this->pillars()[$i]),
              array_keys(array_column($table_2, $this->pillars()[5]), $this->pillars()[$i]));
            array_push($result_2, $array);
          }
        } else {
          $array = [];
          array_push($result_2, $array);
        }
      }
      for($i = 0; $i < count($result_2); $i++) {
        for($j = 0; $j < count($result_2[$i]); $j++) {
          $result_2[$i][$j] = $god_2[$result_2[$i][$j]];
        }
        // print_r($result_2[$i]);
        // echo nl2br(PHP_EOL);
      }
      // echo '-----------------' . nl2br(PHP_EOL);

      //③月支から日干支を見る神煞
      $result_3 = [];
      $god_3 = ['天', '月'];
      $table_3 = [[5, 6, 3, 8, 8, 7, 11, 0, 9, 2, 2, 1]];
      $table_3_2 = [
        [12,12,12,12,12,12,12,12,12,12,12,12],
        [8, 6, 2, 0, 8, 6, 2, 0, 8, 6, 2, 0]
      ];

      for($i = 0; $i < count($this->pillars()); $i++) {
        if($i == 4) {
          if($this->pillars()[3] % 3 != 0) {
            $array = array_merge(
              array_keys(array_column($table_3, $this->pillars()[3]), $this->pillars()[4]),
              array_keys(array_column($table_3_2, $this->pillars()[3]), $this->pillars()[4])
            );
            array_push($result_3, $array);
          } else {
            $array = array_keys(array_column($table_3_2, $this->pillars()[3]), $this->pillars()[4]);
            array_push($result_3, $array);
          }
        } else if($i == 5) {
          if($this->pillars()[3] % 3 == 0) {
            $array = array_keys(array_column($table_3, $this->pillars()[3]), $this->pillars()[5]);
            array_push($result_3, $array);
          } else {
            $array = [];
            array_push($result_3, $array);
          }
        } else {
          $array = [];
          array_push($result_3, $array);
        }
      }
      for($i = 0; $i < count($result_3); $i++) {
        for($j = 0; $j < count($result_3[$i]); $j++) {
          $result_3[$i][$j] = $god_3[$result_3[$i][$j]];
        }
        // print_r($result_3[$i]);
        // echo nl2br(PHP_EOL);
      }
      // echo '-----------------' . nl2br(PHP_EOL);

      //④年支・月支から月、日、時の地支を見る神煞
      $result_4 = [];
      $god_4 = ['孤', '寡', '喪', '弔', '元'];
      $table_4 = [
        [2, 2, 5, 5, 5, 8, 8, 8, 11, 11, 11, 2],
        [10, 10, 1, 1, 1, 4, 4, 4, 7, 7, 7, 10],
        [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 0, 1],
        [10, 11, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
      ];
      if(($this->pillars()[0] + $this->gender) % 2 == 0) {
        array_push($table_4, [7, 8, 9, 10, 11, 0, 1, 2, 3, 4, 5, 6]);
      } else {
        array_push($table_4, [5, 6, 7, 8, 9, 10, 11, 0, 1, 2, 3, 4]);
      }

      for($i = 0; $i < count($this->pillars()); $i++) {
        if($i == 1) {
          $array = array_keys(array_column($table_4, $this->pillars()[5]), $this->pillars()[$i]);
          array_push($result_4, $array);
        } else if($i == 3 || $i == 7) {
          $array = array_merge(
            array_keys(array_column($table_4, $this->pillars()[1]), $this->pillars()[$i]),
            array_keys(array_column($table_4, $this->pillars()[5]), $this->pillars()[$i])
          );
          array_push($result_4, $array);
        } else if($i == 5) {
          $array = array_keys(array_column($table_4, $this->pillars()[1]), $this->pillars()[$i]);
          array_push($result_4, $array);
        } else {
          $array = [];
          array_push($result_4, $array);
        }
      }
      for($i = 0; $i < count($result_4); $i++) {
        for($j = 0; $j < count($result_4[$i]); $j++) {
          $result_4[$i][$j] = $god_4[$result_4[$i][$j]];
        }
        // print_r($result_4[$i]);
        // echo nl2br(PHP_EOL);
      }
      // echo '-----------------' . nl2br(PHP_EOL);

      //⑤空亡を求める
      $result_5 = [];
      if($this->pillars()[4] > $this->pillars()[5]) {
        $num = 10 - ($this->pillars()[4] - $this->pillars()[5]);
      } else if($this->pillars()[4] == $this->pillars()[5]) {
        $num = 10;
      } else {
        $num = ($this->pillars()[5] - $this->pillars()[4]) - 2;
      }
      // $num = (10 + abs(($this->pillars()[5] + 12) - $this->pillars()[4])) % 12;
      // echo $num;
      $table_5 = [$num, $num + 1];
      for($i = 0; $i < count($this->pillars()); $i++) {
        if($i % 2 == 1) {
          if(in_array($this->pillars()[$i], $table_5)) {
            $array = ['空'];
          } else {
            $array = [];
          }
        } else {
          $array = [];
        }
        // echo $i . ':' . $this->pillars()[$i] . ':';
        // print_r($array[$i]);
        // echo nl2br(PHP_EOL);
        array_push($result_5, $array);
      }
      // echo '-----------------' . nl2br(PHP_EOL);

      //⑥魁罡を求める
      // $result_6 = [];
      // for($i = 0; $i < count($this->pillars()); $i++) {
      //   if($i == 5) {
      //     if($this->pillars()[4] == 4 || $this->pillars()[4] == 6) {
      //       if($this->pillars()[5] == 4 || $this->pillars()[5] == 10) {
      //         $array = ['魁'];
      //       } else {
      //         $array = [];
      //       }
      //     } else if($this->pillars()[$i-1] == 2) {
      //       if($this->pillars()[$i] == 10) {
      //         $array = ['魁'];
      //       } else {
      //         $array = [];
      //       }
      //     } else {
      //       $array = [];
      //     }
      //   } else {
      //     $array = [];
      //   }
      //   // if($i % 2 == 1) {
      //   //   if($this->pillars()[$i-1] == 4 || $this->pillars()[$i-1] == 6) {
      //   //     if($this->pillars()[$i] == 4 || $this->pillars()[$i] == 10) {
      //   //       $array = ['魁罡'];
      //   //     } else {
      //   //       $array = [];
      //   //     }
      //   //   } else if($this->pillars()[$i-1] == 2) {
      //   //     if($this->pillars()[$i] == 10) {
      //   //       $array = ['魁罡'];
      //   //     } else {
      //   //       $array = [];
      //   //     }
      //   //   } else {
      //   //     $array = [];
      //   //   }
      //   // } else {
      //   //   $array = [];
      //   // }
      //   array_push($result_6, $array);
      // }

      //⑦三奇を求める
      $result_7 = [];
      for($i = 0; $i < count($this->pillars()); $i++) {
        if($i == 0 || $i == 2){
          $h1 = $this->pillars()[$i];
          $h2 = $this->pillars()[$i + 2];
          $h3 = $this->pillars()[$i + 4];
          if(($h1 == 0 && $h2 == 4 && $h3 == 6) ||
          ($h1 == 1 && $h2 == 2 && $h3 == 3) ||
          ($h1 == 8 && $h2 == 9 && $h3 == 7) ) {
            $array = ['奇'];
          } else {
            $array = [];
          }
        } else {
          $array = [];
        }
        array_push($result_7, $array);
      }

      //神煞をひとつの配列にまとめる。
      for($i = 0; $i < count($result_1); $i++) {
        $result[$i] = array_merge($result_1[$i], $result_2[$i], $result_3[$i], $result_4[$i], $result_5[$i], $result_7[$i]);
      }
      return $result;

    }

  }
