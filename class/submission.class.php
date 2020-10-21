<?php
class form_submission
{
    protected $db;
    protected $DIR;
    protected $interval;

    public function __construct()
    {
        $db = N::_DB();
        $DIR = N::$DIR;
        $inter = N::$interval;
        
        $this->db = $db;
        $this->DIR = $DIR;
        $this->interval = $inter;
    }
    
    public function teaching_apply($firstname, $lastname, $email, $phone, $qualifications, $files)
    {
        $name = preg_replace("#[\'\"]#i", "", $files['name']);
        $size = $files['size'];
        $tmp_name = $files['tmp_name'];
        $error = $files['error'];
        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        $allowed = array("pdf", "mp4");

        if(in_array($ext, $allowed) && $error == 0 && $size <= 10485760)
        {
            $new_name = time().".".$ext;
            if(move_uploaded_file($tmp_name, "../temp/uploaded/Uploaded_$name"))
            {   
                $new = "../temp/uploaded/Uploaded_$name";
                $dest = "../resume/".$firstname."_".$lastname."_".$new_name;
                copy($new, $dest);

                $query = $this->db->prepare("INSERT INTO apply_teacher(fname, lname, email, phone_num, qualifications, resume, time) VALUES (:fname, :lname, :email, :phone_num, :qualifications, :resume, now() + INTERVAL {$this->interval} MINUTE)");
                $query->execute(array(":fname" => $firstname, ":lname" => $lastname, ":email" => $email, ":phone_num" => $phone, ":qualifications" => $qualifications, ":resume" => $firstname."_".$lastname."_".$new_name));
                $sid = $this->db->lastInsertId();
                $subject = "Request successfully submitted";
                $message = "Hi welcome to Fyores! Your application and CV has been submitted successfully. We are reviewing your application and will get back to you soon!";
                $header = "From:help@fyores.com \r\n";
                mail($email, $subject, $message, $header);
                
                return 1;
            }
            else return -1;
        }
        else return -1;
    }
}
?>