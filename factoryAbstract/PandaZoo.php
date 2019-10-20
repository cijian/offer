<?php
namespace factoryAbstract;

class pandazoo implements ZooInterface {

    public function show()
    {
        echo "熊猫园开馆\n";
    }

    public function money()
    {
        $this->show();
        echo "卖门票\n\n";
    }
}
