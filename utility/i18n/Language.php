/**
 * /Language.php
 * Date::                           #$
 * @version $Rev$
 * @package Language
 */

namespace utility\i18n;

/**
 * Description of Language
 * 
 * @package Language
 */
class Language
{

    /**
     * Language parameter
     */
    const LANGUAGE = 'hl';

    /**
     * Default Language
     */
    const DEFAULT_LANGUAGE = 'en';

    /**
     * Supported Language List
     * 
     * @var array
     */
    private $supportedLanguage = array(
        'en' => 'English',
        'ja' => '日本語',
        'zh' => '中文',
        'ko' => '한국어',
    );

    /**
     *
     * @var string 
     */
    private $languge = 'en';

    /**
     * Language Constructor
     */
    public function __construct()
    {
        $hl = isset($_GET[self::LANGUAGE]) ? $_GET[self::LANGUAGE] : @$_COOKIE[self::LANGUAGE];

        if (!$hl) {
            $hl = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        }

        $this->setLanguage($hl);
    }

    /**
     * Change the browser language 
     * 
     * @param string $hl
     * @return \utility\i18n\Language
     */
    public function setLanguage($hl)
    {
        if (!isset($this->supportedLanguage[$hl])) {
            $hl = self::DEFAULT_LANGUAGE;
        }
        $this->languge = $hl;

        return $this;
    }

    /**
     * Return the browser default language
     * 
     * @return string
     */
    public function getLanauge()
    {
        return $this->languge;
    }

    /**
     * Return the default langauge name
     * 
     * @return string
     */
    public function getLanguageName()
    {
        return $this->supportedLanguage[$this->languge];
    }

    /**
     * Return the supported language list of application
     * 
     * @return array
     */
    public function getSupportedLanguage()
    {
        return $this->supportedLanguage;
    }

    /**
     * Return the language instance
     * 
     * @staticvar null $instance
     * @return \self 
     */
    static public function getInstance()
    {
        static $instance = null;

        if (!$instance) {
            $instance = new self;
        }
        return $instance;
    }

}
