<?php

include_once 'includes/mcserverstatus.php';

function QueryMinecraft($host, $port, $showerror = false) {
    $query = new MinecraftQuery();
    try {
        $query->Connect($host, $port);
        return Array (
            'players' => $query->GetInfo(),
            'maxPlayers' => 10,
            'serverVersion' => 15,
            'motd' => 'Test',
        );
    } catch (MinecraftQueryException $e) {
        if($showerror){ echo "Error: " . $e; }
        return false;
    }
}

function getServers() {
    return explode("\n", file_get_contents("servers.txt"));
}

function getHTMLForAllServers() {
    $string = "\n";
    $ips = getServers();
    foreach ($ips as $val){
        $server = getServerInfo($val);
        $string .= tab(3) . "<div class=\"single-server\">\n";
        $string .= createHTMLForServer($server, $val);
        $string .= tab(3) . "</div>\n \n";
    }
    return $string;
}

function getServerInfo($adrs) {
    if (strpos($adrs, ":")) {
      $full = explode(":", $adrs);
      $host = $full[0];
      $port = $full[1];
      $server = QueryMinecraft($host, $port);
    } else {
      $server = QueryMinecraft($adrs, 25565);
    }
    return $server;
}

function createHTMLForServer($server, $name) {
    $string = "";
    $n = "\n";
    
    if ($server === FALSE) {
        $online = false;
    } else {
        $online_players = $server["players"];
        $max_players = $server["maxPlayers"];
        $online = true;
    }
    
    if ($online) {
        $string .= tab(4) . '<p class="online ip">' . $name . '</p>' . $n;
        $string .= tab(4) . '<p class="players"> Players: " . $online_players . "/" . $max_players . "</p>' . $n;
    } else {
        $string .= tab(4) . '<p class="offline ip">' . $name . '</p>' . $n;
        $string .= tab(4) . '<p class="players"> Players: 0/0</p>' . $n;
    }
    
    return $string;
}

function tab($num) {
    $string = "";
    for ($i = 0; $i < $num; $i++) {
        $string .= "\t";
    }
    return $string;
}

?>