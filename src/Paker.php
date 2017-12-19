<?php

namespace SilverStripe\SSPak;

class Paker
{
    private $assets = true;
    private $db = true;

    public function build($filesystem)
    {
        // zip the assets
        // dump and zip the db
        // combine into pak
    }

    public function pakAssetsOnly()
    {
        $this->assets = true;
        $this->db = false;
        return $this;
    }

    public function pakDBOnly()
    {
        $this->assets = false;
        $this->db = true;
        return $this;
    }

    public function removeDB()
    {
        $this->db = false;
        return $this;
    }

    public function removeAssets()
    {
        $this->assets = false;
        return $this;
    }

    public function pakAssets()
    {
        $this->assets = true;
        return $this;
    }

    public function pakDB()
    {
        $this->db = true;
        return $this;
    }
}
