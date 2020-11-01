<?php require_once 'backend/dbconn.php'; ?>
<?php
    if(isset($_REQUEST["language"]) && isset($_REQUEST["code"]))
    {
        $id = $_REQUEST["id"];
        $language = $_REQUEST["language"];
        $code = $_REQUEST["code"];
        
        $sql = "SELECT * FROM `problems` WHERE `pid`=?;";
        $res = $conn->prepare($sql);
        $res->execute([$id]);
        $ans = $res->fetch(PDO::FETCH_ASSOC);
        
        $inputfile = fopen("program_files/input.txt", "w") or die("Unable to open file!");
        fwrite($inputfile, $ans['testcase_input1']);
        fclose($inputfile);

        $inputfile2 = fopen("program_files/input2.txt", "w") or die("Unable to open file!");
        fwrite($inputfile2, $ans['testcase_input2']);
        fclose($inputfile2);
        
        if($language == "Cpp")
        {
            $myfile = fopen("program_files/file.cpp", "w") or die("Unable to open file!");
            fwrite($myfile, $code);
            exec('g++ program_files/file.cpp 2> program_files/error.txt');
            if(0 != filesize('program_files/error.txt'))
                echo readfile('program_files/error.txt');
            else
            {
                $output1 = shell_exec('cat program_files/input.txt | program_files/./a.out');
                $output2 = shell_exec('cat program_files/input2.txt | program_files/./a.out');
                if($output1 == $ans['testcase_output1'] && $output2 == $ans['testcase_output2'])
                    echo "Success";
                else
                    echo "Test cases fail";
            }
            fclose($myfile);
        }
        elseif($language == "Python")
        {
            $myfile = fopen("program_files/file.py", "w") or die("Unable to open file!");
            fwrite($myfile, $code);
            exec('cat program_files/input.txt | python3 program_files/file.py 2> program_files/error.txt');
            if(0 != filesize('program_files/error.txt'))
                echo readfile('program_files/error.txt');
            else
            {
                $output1 = shell_exec('cat program_files/input.txt | python3 program_files/file.py');
                $output2 = shell_exec('cat program_files/input2.txt | python3 program_files/file.py');
                if($output1 == $ans['testcase_output1'] && $output2 == $ans['testcase_output2'])
                    echo "Success";
                else
                    echo "Test cases fail";
            }
            fclose($myfile);
        }
    }
?>
