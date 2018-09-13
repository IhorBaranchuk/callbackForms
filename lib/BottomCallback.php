<?php
require_once('CallbackForm.php');

class BottomCallback extends CallbackForm
{
    private const MAXSIZE = 5242880;
    private const VALIDTYPE = "application/pdf";
    protected $mail;
    private $info;
    private $targetFolder;

    public function __construct(string $name, string $phone, string $mail)
    {
        parent::__construct($name, $phone);
        $this->mail = $mail;
    }

    public function validate(): bool
    {
        if (file_exists($_FILES['uploadFile']['tmp_name'])) {
            $this->info = finfo_open(FILEINFO_MIME_TYPE);
            if (finfo_file($this->info, $_FILES['uploadFile']['tmp_name']) != self::VALIDTYPE) {
                return false;
            }
            if (!($_FILES['uploadFile']['size'] < self::MAXSIZE)) {
                return false;
            }
            $this->targetFolder = "files/";
            if (file_exists($this->targetFolder)) {
                $this->targetFolder = $this->targetFolder . basename($_FILES['uploadFile']['name']);
                move_uploaded_file($_FILES['uploadFile']['tmp_name'], $this->targetFolder);
            } else {
                mkdir($this->targetFolder, 0700, true);
                $this->targetFolder = $this->targetFolder . basename($_FILES['uploadFile']['name']);
                move_uploaded_file($_FILES['uploadFile']['tmp_name'], $this->targetFolder);
            }
        }
        if (!(filter_var($this->mail, FILTER_VALIDATE_EMAIL) || $this->mail == '')) {
            return false;
        }
        return parent::validate();
    }

    public function send()
    {
        parent::send();
        if (!(empty($this->mail))) {
            echo '<br>';
            echo 'Mail: ' . $this->mail;
        }
    }
}