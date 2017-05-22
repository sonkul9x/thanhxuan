<?php
/**
 * added by Dung.nm 3/9/2014
 */
class My_Exceptions extends CI_Exceptions
{

    /**
     * Controller
     *
     * @access public
     */
    function My_Exceptions()
    {
        parent::__construct();
    }

    /**
     * General Error Page
     *
     * @access    private
     * @param    string    disabled - there to keep ci happy
     * @param    string    ditto for this one
     * @param    string    the error function name
     * @return    string
     */
    function show_error($heading, $message, $template = 'error_general', $status_code = 404)
    {
        //Ghi lại nhật ký lỗi
        
        $log = FCPATH . "error_logs/" . date("Y-m-d") . "-" . $template . ".log";

        $date = new DateTime();
        $date = $date->format('Y-m-d H:i:s');

        $text = "";
        $text .= "\n>>> FOUND ERROR at $date <<<";
        $text .= "\n\t\tHeading: $heading";
        $text .= "\n\t\tMessage: " . var_export($message, true);
        $text .= "\n\t\tError code: $template";
        $text .= "\n\t\tError number: $status_code";
        $text .= "\n\t\tServer info: " . var_export($_SERVER, true);
        if (!empty($_REQUEST)) {
            $text .= "\n\t\tRequest info: " . var_export($_REQUEST, true);
        }
        if (!empty($_POST)) {
            $text .= "\n\t\tPost value: " . var_export($_POST, true);
        }
        if (!empty($_GET)) {
            $text .= "\n\t\tGet value: " . var_export($_GET, true);
        }
        $text .= "\n>>> END ERROR at $date <<<\n";

        //xoa het file truoc do
        @array_map('unlink', glob(FCPATH."error_logs/*.log"));
        
        $f = fopen($log, "a");
        fwrite($f, $text);
        fclose($f);
        //kết thúc việc ghi nhật ký lỗi

        if (ENVIRONMENT !== 'development')//Nếu website của bạn không phải đang hoạt động ở chế độ debug thì thay đổi báo lỗi để người dùng không biết thực sự lỗi là gì, điều này rất hữu ích cho việc bảo mật website của bạn
        {
            $heading = "Máy ch&#x1EE7; &#x111;ang quá t&#x1EA3;i";
            $message = "Hi&#x1EC7;n t&#x1EA1;i có quá nhi&#x1EC1;u yêu c&#x1EA7;u g&#x1EED;i t&#x1EDB;i cùng lúc làm máy ch&#x1EE7; &#x111;ang quá t&#x1EA3;i. Xin b&#x1EA1;n vui lòng t&#x1EA3;i l&#x1EA1;i trang (<b>&#x1EA5;n nút F5</b>) sau giây lát.<br />
            Thành th&#x1EAD;t xin l&#x1ED7;i b&#x1EA1;n vì s&#x1EF1; phi&#x1EC1;n hà này, r&#x1EA5;t mong b&#x1EA1;n thông c&#x1EA3;m.";
        }
        return parent::show_error($heading, $message, $template, $status_code);//Trả về nội dung để hiển thị cho lỗi tương ứng
    }

}
