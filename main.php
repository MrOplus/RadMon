<?php
require_once 'vendor/autoload.php';
include('Net/SSH2.php');
include('config.php');
use Dapphp\Radius\Radius;

function notify($msg){
    file_get_contents("https://api.telegram.org/bot".BOT_TOKEN."/sendMessage?chat_id=". CHAT_ID ."&text=" . urlencode($msg));
}
function load(){
    $last_state = 0;
    if(file_exists('last_state')){
        $last_state = (int) file_get_contents('last_state');
    }
    return $last_state;
}
function save($state){
    file_put_contents("last_state",$state);
}
function perform_reboot(){
    $ssh = new Net_SSH2(SSH_HOST);
    if (!$ssh->login(SSH_USERNAME, SSH_PASSWORD)) {
        notify("SSH FAILURE #WTF");
        return;
    }
    try{
        $ssh->exec('reboot');
    }catch(\Exception $e){
        
    }
    $times = load();
    notify("Rebooting Server ...\nTotal Failures : ($times)");
    save(0);
}
$client = new Radius();
$client->setServer(RADIUS_SERVER)
    ->setSecret(RADIUS_SECRET)
    ->setNasPort(200200);
$client->setMSChapPassword(ACCOUNTING_PASSWORD);
$authenticated = $client->accessRequest(ACCOUNTING_USERNAME);

if ($authenticated === false) {
    $times = load();
    $times++;
    save($times);
    notify("Server Is Down ($times)");
    if($times >= FATAL_COUNT ){
        perform_reboot();
    }
} else {
    save(0);
}
