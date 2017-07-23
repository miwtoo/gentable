<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
   <form method="get" action="index.php">
       ปี(พ.ศ.) :<input type="text" name="acadyear" value="2559"><br>
       เทอม :<input type="text" name="semester" value="3"><br>
       รหัสวิชา :<input type="text" name="coursecode" value="103105"><br>
       <input type="submit">
   </form>
    <?php
        
        $acadyear = $_GET['acadyear'];
        $semester = $_GET['semester'];
        $coursecode = $_GET['coursecode'];
        $link = "http://reg.sut.ac.th/registrar/class_info_1.asp?coursestatus=O00&facultyid=all&maxrow=50&acadyear=".$acadyear."&semester=".$semester."&CAMPUSID=&LEVELID=&coursecode=".$coursecode."&coursename=&cmd=2";
            
        include 'Html2Text.php';
        $curl = curl_init($link); 
        curl_setopt($curl, CURLOPT_FAILONERROR, true); 
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); 
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($curl);
        $result = iconv('windows-874','UTF-8',$result);
        
    
        $html = new \Html2Text\Html2Text($result);
        $html_text = $html->getText();
        //echo $html_text;   
    
        /*$path = "D:/AppServ/www";
        $fname = "htmltext.txt";
        $fp = fopen($path."/".$fname,"w");

        
        fwrite($fp,$html_text);
        print "เรียบร้อย";
        fclose($fp);*/
    
        curl_close($curl);
        

    
        preg_match_all("/((MO|TU|WE|TH|FR)[0-9][0-9]:[0-9][0-9]-[0-9][0-9]:[0-9][0-9]\s[A-Z](.+)\n)+.+[0-9]/", $html_text, $matches);
        //echo $matches[1];
        echo '<pre>'; print_r($matches); echo '</pre>';
        //echo $result;
    ?>
</body>
</html>