<?php
function user_type()
{
  return array(
    'realtor' => 'Realtor',
    'user' => 'Users'
  );
}
function sendFCMNotification($data, $device_ids)
{
  $key = "AAAAUB5KlKQ:APA91bE8N391IZ0qy_Hd0xi2HEjHycH88yt09C0yZYjGPSUCudybZ5gf7RlPsUJzepau7lVZ-yrBKa4mBbzV0P02EocId0FUYq0kUw4GvoGs2M8wr5d_OVzlMyi8MNsvJgCiV7540kzw";
  $fields = array();
  if (is_array($device_ids) && count($device_ids) > 1) {
    $fields['registration_ids'] = $device_ids; // multiple user to send push notification
  } else {
    $fields['to'] = $device_ids; // only one user to send push notification
  }
  // $fields['to'] = "dwyYiogARfWoi6_3Z3WjWO:APA91bEoUhgJbAPZDVN2Ew-W9CDrGlwvkw1ghOySjNeasO2dH82Y9FR2_FZ6epvJvlTl0Ir_mRC6h7y8v-MZ98Rbmd49-s61Zk89-xURLr-7J7BxFa7S8GGDaFcx42SxLZKwrqWWYp3F"; // only one user to send push notification
  $fields['notification'] = $data;
  $fields['data'] = array('screenType' => 'order');

  $headers = array(
    'Authorization: key=' . $key,
    'Content-Type: application/json'
  );
  #Send Reponse To FireBase Server
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
  $result = curl_exec($ch);
  curl_close($ch);
  if ($result) {
    return $result;
  }

  return false;
}
?>