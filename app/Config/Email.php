<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public string $fromEmail  = 'amd55077@gmail.com';
    public string $fromName   = 'HOMEKLIK';
    public string $userAgent = 'CodeIgniter';
    public string $protocol = 'mail';
    public string $mailPath = '/usr/sbin/sendmail';
    public string $SMTPHost = 'smtp.example.com';
    public string $SMTPUser = 'codeweaversbd@gmail.com';
    public string $SMTPPass = 'Code@#$2020';
    public int $SMTPPort = 587;
    public int $SMTPTimeout = 5;
    public bool $SMTPKeepAlive = false;
    public string $SMTPCrypto = 'tls';
    public bool $wordWrap = true;
    public int $wrapChars = 76;
    public string $mailType = 'text';
    public string $charset = 'UTF-8';
    public bool $validate = false;
    public int $priority = 3;
    public string $CRLF = "\r\n";
    public string $newline = "\r\n";
    public bool $BCCBatchMode = false;
    public int $BCCBatchSize = 200;
    public bool $DSN = false;
}
