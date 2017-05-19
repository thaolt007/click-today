<?php

//Hàm ghi ra file link.txt
function writelist($record) {
    $filename = "link.txt";
    $file = fopen($filename, "a");

    if ($file == false) {
        // Không mở được file
        return FALSE;
    }
    $size = filesize($filename);
    if ($size == 0) {
        //Khi link.txt chưa có gì
        fwrite($file, $record);
    } else {
        //Khi link.txt đã có dữ liệu
        fwrite($file, "\n" . $record);
    }
    fclose($file);
    return TRUE;
}

//Hàm đọc từ file link.txt
function readlist() {
    $filename = "link.txt";
    $data = array();
    if (!file_exists($filename)) {
        $file = fopen($filename, "a");
    } else {
        $file = fopen($filename, "r");
        if ($file == false) break;
        $size = filesize($filename);
        if ($size) {
            while (!feof($file)) {
                // Lấy từng dòng một
                $record = fgets($file);
                if ($record != '') {
                    $data[] = $record;
                }
            }
        }
    }
    return $data;
}

//#############################################################################
//Phần xử lý ghi ra file link.txt
/*
 * Ghi dữ liệu ra file và trả về thông báo kèm dữ liệu,loại dữ liệu nếu có và thành công
 */
if (isset($_POST['text'])) {

    $today = date("d-m-Y");
    $listday = readlist();
    $i = count($listday);
    $lastday = ( $i == 0 ? '1-1-1970' : $listday[$i-1] );
    $response['code'] = 0;
    $response['error'] = '';
    if ($lastday == $today) {
        $response['error'] = "Hôm nay đã ghi danh";
    } else {
        $status = writelist($today);
        if ($status) {
            $response['code'] = 1;
            $response['day'] = $today;
        } else {
            $response['error'] = "Khong mo duoc file";
        }
    }
    echo json_encode($response);
}

//#############################################################################
//Phần xử lý đọc từ file link.txt khi mới load lần đầu
/*
 * Trả về dữ liệu trong file link.txt
 * Trả về mảng data chưa có phần tử nào nếu chưa có gì trong file
 * Trả về mảng data có các phần tử theo thứ tự từ trên xuống dưới như trong file
 */
$data = readlist();

//#############################################################################
//Hàm in dữ liệu trong data thành danh sách liên kết, text cùng ngày tháng tạo
function printdata($data) {
    $i = count($data);
    while ($i) {
        echo '<button type="button" class="btn btn-info col-md-4">';
        echo '<p>'.$data[--$i].'</p>';
        echo '</button>';
    }
}
?>
