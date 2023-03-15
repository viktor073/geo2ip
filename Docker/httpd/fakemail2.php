<?php

$sendMailStubObj = new SendMailStub();
$sendMailStubObj->main();

class SendMailStub
{
    private $_saveEmailsPath = "/var/mail/"; //change path HERE

    function main()
    {
        //--- get email from the stream ---//
        $stream_data = '';
        $stream_handler = fopen('php://stdin', 'r');
        while ($t = fread($stream_handler, 2048)) {
            if ($t === chr(0))
                break;
            $stream_data .= $t;
        }
        fclose($stream_handler);

        //save to file
        $fwrite_handler = fopen($this->_generateUniquePath(), 'w');
        fwrite($fwrite_handler, $stream_data);
        fclose($fwrite_handler);
    }

    private function _generateUniquePath()
    {
        $i = 0;
        do {
            $path = $this->_saveEmailsPath . $this->_generateFname($i);
            $i++;

            if($i > 100){
                break;
            }
        } while (file_exists($path) == true);

        return $path;
    }

    private function _generateFname($i = 0)
    {
        $parts = array(
            date('Y-m-d_H-i-s'),
        );

        if ($i > 0) {
            $parts[] = "_{$i}";
        }
        $parts[] = ".eml";

        $fname = implode("", $parts);

        return $fname;
    }
}
