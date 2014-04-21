<?php

namespace utility\strings;

class ShortURL {

    var $mChecker = array(50, 51,);
    //abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789
    var $mAlphabet = 'OetMl3cbTrwzEis7RXH5gKUkNqafdSFIQ0jDWYhuLyP2JGvZ9p6m1AV4oB8nxC';
    var $mBase = 0;
    var $mLength = 0;

    function __construct($mLength = 0) {
        $this->mAlphabet = str_split($this->mAlphabet);
        $this->mBase = count($this->mAlphabet);
        $this->mLength = $mLength;
    }

    /**
     * cryptAlphabet may produce a random Alphabet string.
     * 
     * @param int $loop
     * @return string
     */
    function cryptAlphabet($loop = 60) {
        $mAlphabet = $this->mAlphabet;
        for ($i = 0; $i < $loop; $i++) {
            $mNewAlpha = array();
            do {
                $i = rand(0, $this->mBase) % $this->mBase;
                if (!in_array($mAlphabet[$i], $mNewAlpha)) {
                    $mNewAlpha[] = $mAlphabet[$i];
                }
                if (count($mNewAlpha) == $this->mBase)
                    break;
            } while (TRUE);
            $mAlphabet = $mNewAlpha;
        }
        return implode('', $mAlphabet);
    }

    /**
     * encode may produce one short string based on the input id. 
     * It is not necessarty to store the short string into DB. 
     * It can reverse it into id when the clients access.
     * 
     * If you want to add checker on short url, please set mChecker=TRUE.
     * The checker length is based on the $this->mChecker length.
     * 
     * @param int $id
     * @param bool $mChecker
     * @return string 
     */
    function encode($id = 0, $mChecker = TRUE) {
        $mShortURL = '';
        $id = (int) $id; // to interger
        if ($id > 0) {
            if ($mChecker) {
                $mChecker = $this->chekcer($id);
            } else {
                $mChecker = '';
            }
            while ($id > 0) {
                $mShortURL = $this->mAlphabet[$id % $this->mBase] . $mShortURL;
                $id = (int) ($id / $this->mBase);
            }
            $mShortURL = $mChecker . $mShortURL;
        }
        return $mShortURL;
    }

    /**
     * 
     * @param string $mShortURL
     * @param bool $mChecker
     * @return int|null
     */
    function decode($mShortURL = '', $mChecker = TRUE) {

        $mChekcerLength = $mChecker ? count($this->mChecker) : 0;

        if (strlen($mShortURL) <= $mChekcerLength) {
            return FALSE;
        }

        if ($mChekcerLength) {
            $mChecker = substr($mShortURL, 0, $mChekcerLength);
            $mShortURL = substr($mShortURL, $mChekcerLength);
        } else {
            $mChecker = FALSE;
        }

        //string to integer
        $id = 0;
        foreach (str_split($mShortURL) as $value) {
            $id = $id * $this->mBase + array_search($value, $this->mAlphabet);
        }

        if ($mChekcerLength && $this->chekcer($id) !== $mChecker) {
            $id = FALSE;
        }

        return $id;
    }

    protected function chekcer(&$id = 0, $mCheckerFlg = TRUE) {
        $mChecker = '';
        if ($mCheckerFlg) {
            foreach ($this->mChecker as $value) {
                $mChecker .=$this->mAlphabet[$id % $value];
            }
        }
        return $mChecker;
    }

}
