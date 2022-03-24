<h1 class="heading">命式診断</h1>
<!-- <div id="checker"> -->
  <form id="checker" method='post' action="../judge.php">
    <?php
      if(empty($_POST['date'])) {
        echo "<p>生年月日と性別を入力してください。</p>";
      }
    ?>
    <table>
      <tr>
        <th>
          <label for="name">氏名</label>
        </th>
        <td>
          <input type="text" name="name" value=<?php echo $_POST['name']; ?>>
        </td>
      </tr>
      <tr>
        <th>
          <label>生年月日</label>
        </th>
        <td>
          <select name="year" id="year">
            <?php
              if(empty($_POST['year'])) {
                for($i = 1924; $i < 2065; $i++) {
                  echo "<option value='$i' ";
                  if($i == date('Y')) {
                    echo 'selected';
                  }
                  echo "> $i </option>";
                }
              } else {
                for($i = 1924; $i < 2065; $i++) {
                  echo "<option value='$i' ";
                  if($i == $_POST['year']) {
                    echo 'selected';
                  }
                  echo "> $i </option>";
                }
              }
            ?>
          </select>
          <select name="month" id="month">
            <?php
              if(empty($_POST['month'])) {
                for($i = 1; $i < 13; $i++) {
                  echo "<option value='$i' ";
                  if($i == date('m')) {
                    echo 'selected';
                  }
                  echo "> $i </option>";
                }
              } else {
                for($i = 1; $i < 13; $i++) {
                  echo "<option value='$i' ";
                  if($i == $_POST['month']) {
                    echo 'selected';
                  }
                  echo "> $i </option>";
                }
              }
            ?>
          </select>
          <select name="day" id="day">
            <?php
              if(empty($_POST['day'])) {
                for($i = 1; $i < 32; $i++) {
                  echo "<option value='$i' ";
                  if($i == date('d')) {
                    echo "selected";
                  }
                  echo "> $i </option>";
                }
              } else {
                for($i = 1; $i < 32; $i++) {
                  echo "<option value='$i' ";
                  if($i == $_POST['day']) {
                    echo "selected";
                  }
                  echo "> $i </option>";
                }
              }
            ?>
          </select>
          <!-- <input type="date" name='date' min="1924-01-01" max='2064-12-31' value=<?php echo $_POST['date']; ?>> -->
        </td>
      </tr>
      <tr>
        <th>
          <label for="time">時間</label>
        </th>
        <td>
          <input type="time" name="time" value=<?php echo $_POST['time']; ?>>
        </td>
      </tr>
      <tr>
        <th>
          <label for='gender'>性別</label>
        </th>
        <td>
          <?php genderChecked($_POST['gender']); ?>
        </td>
      </tr>
    </table>
    <div class="img-center">
      <input class="judge-button btn" type='submit' value="鑑 定">
    </div>
  </form>
<!-- </div> -->
