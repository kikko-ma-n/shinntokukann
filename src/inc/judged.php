<h1 class="heading">
    診断結果
    <div style="float: right; font-weight: normal; font-size: 0.9em;">
        <?php if($_POST['name']) echo $_POST['name'] ?> 様
    </div>
</h1>
    <?php $personal = new Personal($_POST['year'], $_POST['month'], $_POST['day'], $_POST['time'], $_POST['gender']); ?>
    <div class="judged-area-1">
        <table class="pillars">
            <caption>命式</caption>
            <thead>
                <tr>
                    <th class="th-1"></th>
                    <th colspan="3" class="head">時　柱</th>
                    <th colspan="3" class="head">日　柱</th>
                    <th colspan="3" class="head">月　柱</th>
                    <th colspan="3" class="head">年　柱</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th rowspan="2">天干</th>
                    <td colspan="3" class="pillar-char border-right"><?php echo $personal->pillars[6] ?></td>
                    <td class="btw_box"><?php echo $personal->god[4][0] ?></td>
                    <td class="pillar-char"><?php echo $personal->pillars[4] ?></td>
                    <td class="border-right btw_box"><?php echo $personal->god[4][1] ?></td>
                    <td class="btw_box"><?php echo $personal->god[2][0] ?></td>
                    <td class="pillar-char"><?php echo $personal->pillars[2] ?></td>
                    <td class="border-right btw_box"><?php echo $personal->god[2][1] ?></td>
                    <td class="btw_box"><?php echo $personal->god[0][0] ?></td>
                    <td class="pillar-char"><?php echo $personal->pillars[0] ?></td>
                    <td class="border-right btw_box"><?php echo $personal->god[0][1] ?></td>
                </tr>
                <tr class="border-top-dashed">
                    <td colspan="3"><?php echo $personal->pillars_five[6] ?></td>
                    <td colspan="3"><?php echo $personal->pillars_five[4] ?></td>
                    <td colspan="3"><?php echo $personal->pillars_five[2] ?></td>
                    <td colspan="3"><?php echo $personal->pillars_five[0] ?></td>
                </tr>
                <tr class="table-border">
                    <th>通変星</th>
                    <td colspan="3"><?php echo $personal->pillars_ten[3] ?></td>
                    <td colspan="3"><?php ?></td>
                    <td colspan="3"><?php echo $personal->pillars_ten[1] ?></td>
                    <td colspan="3"><?php echo $personal->pillars_ten[0] ?></td>
                </tr>
                <tr>
                    <th rowspan="5">地支</th>
                    <td class="btw_box"><?php echo $personal->god[7][0] ?></td>
                    <td class="pillar-char" rowspan="4"><?php echo $personal->pillars[7] ?></td>
                    <td class="border-right btw_box"><?php echo $personal->god[7][1] ?></td>
                    <td><?php echo $personal->god[5][0] ?></td>
                    <td class="pillar-char" rowspan="4"><?php echo $personal->pillars[5] ?></td>
                    <td class="border-right"><?php echo $personal->god[5][1] ?></td>
                    <td><?php echo $personal->god[3][0] ?></td>
                    <td class="pillar-char" rowspan="4"><?php echo $personal->pillars[3] ?></td>
                    <td class="border-right"><?php echo $personal->god[3][1] ?></td>
                    <td><?php echo $personal->god[1][0] ?></td>
                    <td class="pillar-char" rowspan="4"><?php echo $personal->pillars[1] ?></td>
                    <td class="border-right"><?php echo $personal->god[1][1] ?></td>
                </tr>
                <tr>
                    <!-- 地支中段 -->
                    <td><?php echo $personal->god[7][4] ?></td>
                    <td class="border-right"><?php echo $personal->god[7][5] ?></td>
                    <td><?php echo $personal->god[5][4] ?></td>
                    <td class="border-right"><?php echo $personal->god[5][5] ?></td>
                    <td><?php echo $personal->god[3][4] ?></td>
                    <td class="border-right"><?php echo $personal->god[3][5] ?></td>
                    <td><?php echo $personal->god[1][4] ?></td>
                    <td class="border-right"><?php echo $personal->god[1][5] ?></td>
                </tr>
                <tr>
                    <!-- 地支中段 -->
                    <td><?php echo $personal->god[7][6] ?></td>
                    <td class="border-right"><?php echo $personal->god[7][7] ?></td>
                    <td><?php echo $personal->god[5][6] ?></td>
                    <td class="border-right"><?php echo $personal->god[5][7] ?></td>
                    <td><?php echo $personal->god[3][6] ?></td>
                    <td class="border-right"><?php echo $personal->god[3][7] ?></td>
                    <td><?php echo $personal->god[1][6] ?></td>
                    <td class="border-right"><?php echo $personal->god[1][7] ?></td>
                </tr>
                <tr>
                    <!-- 地支中段 -->
                    <td><?php echo $personal->god[7][2] ?></td>
                    <td class="border-right"><?php echo $personal->god[7][3] ?></td>
                    <td><?php echo $personal->god[5][2] ?></td>
                    <td class="border-right"><?php echo $personal->god[5][7] ?></td>
                    <td><?php echo $personal->god[3][2] ?></td>
                    <td class="border-right"><?php echo $personal->god[3][3] ?></td>
                    <td><?php echo $personal->god[1][2] ?></td>
                    <td class="border-right"><?php echo $personal->god[1][3] ?></td>
                </tr>
                <tr class="border-top-dashed">
                    <td colspan="3"><?php echo $personal->pillars_five[7] ?></td>
                    <td colspan="3"><?php echo $personal->pillars_five[5] ?></td>
                    <td colspan="3"><?php echo $personal->pillars_five[3] ?></td>
                    <td colspan="3"><?php echo $personal->pillars_five[1] ?></td>
                </tr>
                <tr class="table-border">
                    <th>十二運</th>
                    <td colspan="3"><?php echo $personal->pillars_twelve[3] ?></td>
                    <td colspan="3"><?php echo $personal->pillars_twelve[2] ?></td>
                    <td colspan="3"><?php echo $personal->pillars_twelve[1] ?></td>
                    <td colspan="3"><?php echo $personal->pillars_twelve[0] ?></td>
                </tr>
                <tr>
                    <th rowspan="3">蔵干</th>
                    <td class="border-right" colspan="3"><?php echo $personal->zokan[3][0] ?></td>
                    <td class="border-right" colspan="3"><?php echo $personal->zokan[2][0] ?></td>
                    <td class="border-right" colspan="3"><?php echo $personal->zokan[1][0] ?></td>
                    <td class="border-right" colspan="3"><?php echo $personal->zokan[0][0] ?></td>
                </tr>
                <tr>
                    <td class="border-right" colspan="3"><?php echo $personal->zokan[3][1] ?></td>
                    <td class="border-right" colspan="3"><?php echo $personal->zokan[2][1] ?></td>
                    <td class="border-right" colspan="3"><?php echo $personal->zokan[1][1] ?></td>
                    <td class="border-right" colspan="3"><?php echo $personal->zokan[0][1] ?></td>
                </tr>
                <tr>
                    <td class="border-right" colspan="3"><?php echo $personal->zokan[3][2] ?></td>
                    <td class="border-right" colspan="3"><?php echo $personal->zokan[2][2] ?></td>
                    <td class="border-right" colspan="3"><?php echo $personal->zokan[1][2] ?></td>
                    <td class="border-right" colspan="3"><?php echo $personal->zokan[0][2] ?></td>
                </tr>
            </tbody>
        </table>
        <div class="pentagon">
            <div class="pent-title">五行のバランス</div>
            <?php
            for($i = 0; $i < 5; $i++) {
                $five = ($personal->five_main + $i) % 5;
                echo "<div class='pent pent-$i'>" . FIVE_LINE[$five] . "</div>";
                // echo $personal->five_line[$five];
                echo "<div class='point point-$i'>";
                for($j = 0; $j < $personal->five_line[$five]; $j++) {
                    echo "●";
                }
                echo "</div>";
            }
            ?>
        </div>
    </div>
    <div class="judged-area-2">
        <table class="pillars">
            <caption>大運
                <span style="font-weight: 100; font-size: 18px">
                    （立命：<?php echo $personal->up_year[0] . "年" . $personal->up_month . "月～）" ?>
                </span>
            </caption>
            <thead>
                <tr>
                    <th class="th-1">西暦</th>
                    <th class="th-2">生後</th>
                    <?php
                        for($i = 0; $i < 9; $i++) {
                            echo "<th class='th-2'>" . $personal->up_year[$i] . "</th>";
                        }
                    ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th rowspan="2">天干</th>
                    <?php
                        for($i = 0; $i < 20; $i+=2) {
                            echo "<td class='pillar-char border-right'>" . $personal->fate[$i] . "</td>";
                        }
                    ?>
                </tr>
                <tr class="border-top-dashed">
                    <?php
                        for($i = 0; $i < 20; $i+=2) {
                            echo "<td>" . $personal->fate_five[$i] . "</td>";
                        }
                    ?>
                </tr>
                <tr class="table-border">
                    <th>通変星</th>
                    <?php
                        for($i = 0; $i < 10; $i++) {
                            echo "<td>" . $personal->fate_ten[$i] . "</td>";
                        }
                    ?>
                </tr>
                <tr>
                    <th rowspan="2">地支</th>
                    <?php
                        for($i = 1; $i < 20; $i+=2) {
                            echo "<td class='pillar-char border-right'>" . $personal->fate[$i] . "</td>";
                        }
                    ?>
                </tr>
                <tr class="border-top-dashed">
                    <?php
                        for($i = 1; $i < 20; $i+=2) {
                            echo "<td>" . $personal->fate_five[$i] . "</td>";
                        }
                    ?>
                </tr>
                <tr class="table-border">
                    <th>十二運</th>
                    <?php
                        for($i = 0; $i < 10; $i++) {
                            echo "<td>" . $personal->fate_twelve[$i] . "</td>";
                        }
                    ?>
                </tr>
            </tbody>
        </table>
        <div style="font-size: 15px;">※ 正しい立命を知りたい場合は出生時間を正確に入力してください。</div>
    </div>
