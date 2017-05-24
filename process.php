<?php

//Hàm ghi ra file listday.txt
function writelist($record, $filename) {
    $file = fopen($filename, "a");

    if ($file == false) {
        // Không mở được file
        return FALSE;
    }
    $size = filesize($filename);
    if ($size == 0) {
        //Khi listday.txt chưa có gì
        fwrite($file, $record);
    } else {
        //Khi listday.txt đã có dữ liệu
        fwrite($file, "\n" . $record);
    }
    fclose($file);
    return TRUE;
}

//Hàm đọc từ file listday.txt
function readlist($filename) {
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

//Hàm reset file listday.txt
function resetlist($filename) {
    $file = fopen($filename, "w");
    if ($file == false) return false;
    else return true;
}

//#############################################################################
//Phần xử lý ghi ra file listday.txt
/*
 * Ghi dữ liệu ra file và trả về thông báo kèm dữ liệu,loại dữ liệu nếu có và thành công
 */
if (isset($_POST['text'])) {

    $today = date("d-m-Y");
    $listday = readlist("listday.txt");
    $i = count($listday);
    $lastday = ( $i == 0 ? '1-1-1970' : $listday[$i-1] );
    $response['code'] = 0;
    $response['error'] = '';
    if ($lastday == $today) {
        $response['error'] = "Hôm nay đã ghi danh";
    } else {
        $status = writelist($today,'listday.txt');
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
//Phần đặt lại file listday.txt - rỗng
/*
 * Trả về thông báo nếu thành công
 */
if (isset($_POST['reset'])) {
    $listday = resetlist("listday.txt");
    $response['code'] = '0';
    if ($listday) {
        $response['code'] = '1';
        $response['success'] = 'Đặt lại file thành công, file bây giờ rỗng.';
    }
    else {
        $response['error'] = 'Lỗi mở tạo file.';
    }
    echo json_encode($response);
}

//#############################################################################
//Phần xử lý đọc từ file listday.txt khi mới load lần đầu
/*
 * Trả về dữ liệu trong file listday.txt
 * Trả về mảng data chưa có phần tử nào nếu chưa có gì trong file
 * Trả về mảng data có các phần tử theo thứ tự từ trên xuống dưới như trong file
 */
$data = readlist('listday.txt');

//#############################################################################
//Hàm in dữ liệu trong data thành danh sách liên kết, text cùng ngày tháng tạo
function printdata($data) {
    $i = count($data);
    while ($i) {
        echo '<button type="button" class="btn btn-info col-md-3">';
        echo '<p>'.$data[--$i].'</p>';
        echo '</button>';
    }
}
?>
