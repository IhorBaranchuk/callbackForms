<?php
require_once('FormAbstract.php');

class CallbackForm extends FormAbstract
{
    public $name;
    public $phone;

    public function __construct(string $name, string $phone)
    {
        $this->name = $name;
        $this->phone = $phone;
    }

    public function validate(): bool
    {
        if (empty($this->name) || strlen($this->name) > 20 || strlen($this->name) < 2) {
            return false;
        }
        if (empty($this->phone) || strlen($this->phone) < 7 || strlen($this->phone) > 15) {
            return false;
        }
        return true;
    }

    public function send()
    {
        echo 'Форма успешно отправлена!<br>';
        echo 'Name: ' . $this->name;
        echo '<br>';
        echo 'Phone: ' . $this->phone;
    }
}