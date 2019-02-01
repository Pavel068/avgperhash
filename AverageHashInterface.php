<?php

namespace app;

interface AverageHashInterface
{

    /**
     * @return mixed
     */
    public function resizeImage();

    /**
     * @return mixed
     */
    public function imageToGray();

    /**
     * @return mixed
     */
    public function getAverageColor();

    /**
     * @return mixed
     */
    public function getBitChain();

    /**
     * @return mixed
     */
    public function makeHash();

}