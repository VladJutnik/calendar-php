<?php
date_default_timezone_set('europe/moscow');

if (isset($_GET['ym'])) {
    $ym = $_GET['ym'];
} else {
    $ym = date('Y-m');
}

// проверка формата даты + добавляем к году и месяцу первый день
$timestamp = strtotime($ym . '-01');
if ($timestamp === false) {
    $ym = date('Y-m');
    $timestamp = strtotime($ym . '-01');
}

// сегоднящняя дата
$today = date('Y-m-j', time());

// для заголовка месяц и год
$html_title = date('m.y', $timestamp);
$month = date('m', $timestamp);
$year = date('Y', $timestamp);

// Создаем начальную и конечную дату по выборке  prev & next mktime(hour,minute,second,month,day,year)
$prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)-1, 1, date('Y', $timestamp)));
$next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)+1, 1, date('Y', $timestamp)));
// Создаем начальную и конечную дату по выборке  prev & next mktime(hour,minute,second,month,day,year)
$prev2 = date('Y-m', strtotime('-1 month', $timestamp)); //предыдушийй месяц
$next2 = date('Y-m', strtotime('+1 month', $timestamp)); //следующий месяц

// Количество дней в месяце
$day_count = date('t', $timestamp);


$str2 = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));
//$str = date('w', $timestamp);
$str = date('N', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));
$str--;

$weeks = array();
$week = '';

// $str - количесвто дней пустых в месце перед первым днем !
$week .= str_repeat('<td></td>', $str);//добавили пустые ячейки перед первым днем месяцы!

for ( $day = 1; $day <= $day_count; $day++, $str++) {

    $date = $ym . '-' . $day;

    if ($today == $date) {
        $week .= '<td style="font-size: xxx-large; background: #6c76d9">' . $day;
    } else {
        $week .= '<td style="font-size: xxx-large"><b>' . $day . '</b>';
    }
    $week .= '</td>';

    // Конец недели ИЛИ конец месяца
    if ($str % 7 == 6 || $day == $day_count) {

        if ($day == $day_count) {
            // Добавить пустую ячейку
            $week .= str_repeat('<td></td>', 6 - ($str % 7));
        }

        $weeks[] = '<tr>' . $week . '</b></tr>';

        // Prepare for new week
        $week = '';
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>PHP календарь</title>
    <style>
        .container {
            margin-top: 80px;
        }
        h3 {
            margin-bottom: 30px;
        }
        th {
            height: 30px;
            text-align: center;
        }
        td {
            height: 100px;
            border: 2px solid black;
        }
        .table2 {
            width: 100% !important;
            border: none !important;
            margin-bottom: 20px !important;
        }
        .table th {
            font-weight: bold;
            text-align: center;
            border: none;
            padding: 10px 15px;
            background: #d8d8d8;
            font-size: 14px;
        }
        td:nth-of-type(7) {
            border-right: none;
        }
        td:nth-of-type(1) {
            border-left: none;
        }
    </style>
</head>
<body>
<div class="container">
    <h3><a href="?ym=<?php echo $prev; ?>">пред. месяц</a> <?php echo $html_title; ?> <a href="?ym=<?php echo $next; ?>">след. месяц</a></h3>
    <table class="table2 ">
        <tr>

            <th>понедельник</th>
            <th>втонник</th>
            <th>среда</th>
            <th>четверг</th>
            <th>пятница</th>
            <th>субота</th>
            <th>воскресение</th>
        </tr>
        <?php
        foreach ($weeks as $week) {
            echo $week;
        }
        ?>
    </table>
</div>
</body>
</html>