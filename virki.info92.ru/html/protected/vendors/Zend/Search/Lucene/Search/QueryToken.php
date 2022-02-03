<?php
/**
 * Zend Framework
 * LICENSE
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 * @category   Zend
 * @package    Zend_Search_Lucene
 * @subpackage Search
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */

/**
 * @category   Zend
 * @package    Zend_Search_Lucene
 * @subpackage Search
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Search_Lucene_Search_QueryToken
{
    const TC_NUMBER = 2;  // Word
    const TC_PHRASE = 1;  // Phrase (one or several quoted words)
    const TC_SYNTAX_ELEMENT = 3;  // Field name in 'field:word', field:<phrase> or field:(<subquery>) pairs
    /**
     * TokenCategories
     */
    const TC_WORD = 0;  // ':'
    const TT_AND_LEXEME = 14;  // '+'
    const TT_BOOSTING_MARK = 7;  // '-'
    const TT_FIELD = 2;  // '~'
    const TT_FIELD_INDICATOR = 3;  // '^'
    const TT_FUZZY_PROX_MARK = 6;  // '['
    const TT_NOT_LEXEME = 16;  // ']'
    const TT_NUMBER = 18; // '{'
    const TT_OR_LEXEME = 15; // '}'
    const TT_PHRASE = 1; // '('
    const TT_PROHIBITED = 5; // ')'
    const TT_RANGE_EXCL_END = 11; // 'AND' or 'and'
    const TT_RANGE_EXCL_START = 10; // 'OR'  or 'or'
    const TT_RANGE_INCL_END = 9; // 'NOT' or 'not'
    const TT_RANGE_INCL_START = 8; // 'TO'  or 'to'
    const TT_REQUIRED = 4; // Number, like: 10, 0.8, .64, ....
    const TT_SUBQUERY_END = 13;
    const TT_SUBQUERY_START = 12;   // Word
    const TT_TO_LEXEME = 17;   // Phrase (one or several quoted words)
    /**
     * Token types.
     */
    const TT_WORD = 0;   // Nubers, which are used with syntax elements. Ex. roam~0.8

    /**
     * IndexReader constructor needs token type and token text as a parameters.
     * @param integer $tokenCategory
     * @param string  $tokText
     * @param integer $position
     */
    public function __construct($tokenCategory, $tokenText, $position)
    {
        $this->text = $tokenText;
        $this->position = $position + 1; // Start from 1

        switch ($tokenCategory) {
            case self::TC_WORD:
                if (strtolower($tokenText) == 'and') {
                    $this->type = self::TT_AND_LEXEME;
                } else {
                    if (strtolower($tokenText) == 'or') {
                        $this->type = self::TT_OR_LEXEME;
                    } else {
                        if (strtolower($tokenText) == 'not') {
                            $this->type = self::TT_NOT_LEXEME;
                        } else {
                            if (strtolower($tokenText) == 'to') {
                                $this->type = self::TT_TO_LEXEME;
                            } else {
                                $this->type = self::TT_WORD;
                            }
                        }
                    }
                }
                break;

            case self::TC_PHRASE:
                $this->type = self::TT_PHRASE;
                break;

            case self::TC_NUMBER:
                $this->type = self::TT_NUMBER;
                break;

            case self::TC_SYNTAX_ELEMENT:
                switch ($tokenText) {
                    case ':':
                        $this->type = self::TT_FIELD_INDICATOR;
                        break;

                    case '+':
                        $this->type = self::TT_REQUIRED;
                        break;

                    case '-':
                        $this->type = self::TT_PROHIBITED;
                        break;

                    case '~':
                        $this->type = self::TT_FUZZY_PROX_MARK;
                        break;

                    case '^':
                        $this->type = self::TT_BOOSTING_MARK;
                        break;

                    case '[':
                        $this->type = self::TT_RANGE_INCL_START;
                        break;

                    case ']':
                        $this->type = self::TT_RANGE_INCL_END;
                        break;

                    case '{':
                        $this->type = self::TT_RANGE_EXCL_START;
                        break;

                    case '}':
                        $this->type = self::TT_RANGE_EXCL_END;
                        break;

                    case '(':
                        $this->type = self::TT_SUBQUERY_START;
                        break;

                    case ')':
                        $this->type = self::TT_SUBQUERY_END;
                        break;

                    case '!':
                        $this->type = self::TT_NOT_LEXEME;
                        break;

                    case '&&':
                        $this->type = self::TT_AND_LEXEME;
                        break;

                    case '||':
                        $this->type = self::TT_OR_LEXEME;
                        break;

                    default:
                        require_once 'Zend/Search/Lucene/Exception.php';
                        throw new Zend_Search_Lucene_Exception(
                          'Unrecognized query syntax lexeme: \'' . $tokenText . '\''
                        );
                }
                break;

            case self::TC_NUMBER:
                $this->type = self::TT_NUMBER;

            default:
                require_once 'Zend/Search/Lucene/Exception.php';
                throw new Zend_Search_Lucene_Exception('Unrecognized lexeme type: \'' . $tokenCategory . '\'');
        }
    }   // +  -  ( )  [ ]  { }  !  ||  && ~ ^

    /**
     * Token position within query.
     * @var integer
     */
    public $position;
    /**
     * Token text.
     * @var integer
     */
    public $text;
    /**
     * Token type.
     * @var integer
     */
    public $type;

    /**
     * Returns all possible lexeme types.
     * It's used for syntax analyzer state machine initialization
     * @return array
     */
    public static function getTypes()
    {
        return [
          self::TT_WORD,
          self::TT_PHRASE,
          self::TT_FIELD,
          self::TT_FIELD_INDICATOR,
          self::TT_REQUIRED,
          self::TT_PROHIBITED,
          self::TT_FUZZY_PROX_MARK,
          self::TT_BOOSTING_MARK,
          self::TT_RANGE_INCL_START,
          self::TT_RANGE_INCL_END,
          self::TT_RANGE_EXCL_START,
          self::TT_RANGE_EXCL_END,
          self::TT_SUBQUERY_START,
          self::TT_SUBQUERY_END,
          self::TT_AND_LEXEME,
          self::TT_OR_LEXEME,
          self::TT_NOT_LEXEME,
          self::TT_TO_LEXEME,
          self::TT_NUMBER,
        ];
    }
}
