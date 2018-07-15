<?php
require_once('CallbackForm.php');

class BottomCallback extends CallbackForm
{
    public $mail;
    private $info;
    private $target_folder;

    public function __construct(string $name, string $phone, string $mail)
    {
        parent::__construct($name, $phone);
        $this->mail = $mail;
    }

    public function validate(): bool
    {
        $this->info = new SplFileInfo($_FILES['uploadFile']['name']);
        if (!($this->info->getExtension() == "pdf" || $this->info->getExtension() == "PDF" || $this->info == "")) {
            return false;
        }
        if (!($_FILES['uploadFile']['size'] < 5242880)) {
            return false;
        }
        $this->target_folder = "files/";
        if (file_exists($this->target_folder)) {
            $this->target_folder = $this->target_folder . basename($_FILES['uploadFile']['name']);
            move_uploaded_file($_FILES['uploadFile']['tmp_name'], $this->target_folder);
        } else {
            mkdir($this->target_folder, 0700, true);
            $this->target_folder = $this->target_folder . basename($_FILES['uploadFile']['name']);
            move_uploaded_file($_FILES['uploadFile']['tmp_name'], $this->target_folder);
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
