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

/** Internally used classes */

/** Zend_Search_Lucene_Analysis_Analyzer */
require_once 'Zend/Search/Lucene/Analysis/Analyzer.php';

/** Zend_Search_Lucene_Search_QueryToken */
require_once 'Zend/Search/Lucene/Search/QueryToken.php';

/** Zend_Search_Lucene_FSM */
require_once 'Zend/Search/Lucene/FSM.php';

/**
 * @category   Zend
 * @package    Zend_Search_Lucene
 * @subpackage Search
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Search_Lucene_Search_QueryParser extends Zend_Search_Lucene_FSM
{
    const B_AND = 1;
    /**
     * Boolean operators constants
     */
    const B_OR = 0;
    const ST_CLOSEDINT_RQ_END = 5;
    const ST_CLOSEDINT_RQ_FIRST_TERM = 2;
    const ST_CLOSEDINT_RQ_LAST_TERM = 4;
    const ST_CLOSEDINT_RQ_START = 1;
    const ST_CLOSEDINT_RQ_TO_TERM = 3;
    /** Query parser State Machine states */
    const ST_COMMON_QUERY_ELEMENT = 0;
    const ST_OPENEDINT_RQ_END = 10;
    const ST_OPENEDINT_RQ_FIRST_TERM = 7;
    const ST_OPENEDINT_RQ_LAST_TERM = 9;
    const ST_OPENEDINT_RQ_START = 6;
    const ST_OPENEDINT_RQ_TO_TERM = 8;

    /**
     * Parser constructor
     */
    public function __construct()
    {
        parent::__construct(
          [
            self::ST_COMMON_QUERY_ELEMENT,
            self::ST_CLOSEDINT_RQ_START,
            self::ST_CLOSEDINT_RQ_FIRST_TERM,
            self::ST_CLOSEDINT_RQ_TO_TERM,
            self::ST_CLOSEDINT_RQ_LAST_TERM,
            self::ST_CLOSEDINT_RQ_END,
            self::ST_OPENEDINT_RQ_START,
            self::ST_OPENEDINT_RQ_FIRST_TERM,
            self::ST_OPENEDINT_RQ_TO_TERM,
            self::ST_OPENEDINT_RQ_LAST_TERM,
            self::ST_OPENEDINT_RQ_END,
          ],
          Zend_Search_Lucene_Search_QueryToken::getTypes()
        );

        $this->addRules(
          [
            [
              self::ST_COMMON_QUERY_ELEMENT,
              Zend_Search_Lucene_Search_QueryToken::TT_WORD,
              self::ST_COMMON_QUERY_ELEMENT,
            ],
            [
              self::ST_COMMON_QUERY_ELEMENT,
              Zend_Search_Lucene_Search_QueryToken::TT_PHRASE,
              self::ST_COMMON_QUERY_ELEMENT,
            ],
            [
              self::ST_COMMON_QUERY_ELEMENT,
              Zend_Search_Lucene_Search_QueryToken::TT_FIELD,
              self::ST_COMMON_QUERY_ELEMENT,
            ],
            [
              self::ST_COMMON_QUERY_ELEMENT,
              Zend_Search_Lucene_Search_QueryToken::TT_REQUIRED,
              self::ST_COMMON_QUERY_ELEMENT,
            ],
            [
              self::ST_COMMON_QUERY_ELEMENT,
              Zend_Search_Lucene_Search_QueryToken::TT_PROHIBITED,
              self::ST_COMMON_QUERY_ELEMENT,
            ],
            [
              self::ST_COMMON_QUERY_ELEMENT,
              Zend_Search_Lucene_Search_QueryToken::TT_FUZZY_PROX_MARK,
              self::ST_COMMON_QUERY_ELEMENT,
            ],
            [
              self::ST_COMMON_QUERY_ELEMENT,
              Zend_Search_Lucene_Search_QueryToken::TT_BOOSTING_MARK,
              self::ST_COMMON_QUERY_ELEMENT,
            ],
            [
              self::ST_COMMON_QUERY_ELEMENT,
              Zend_Search_Lucene_Search_QueryToken::TT_RANGE_INCL_START,
              self::ST_CLOSEDINT_RQ_START,
            ],
            [
              self::ST_COMMON_QUERY_ELEMENT,
              Zend_Search_Lucene_Search_QueryToken::TT_RANGE_EXCL_START,
              self::ST_OPENEDINT_RQ_START,
            ],
            [
              self::ST_COMMON_QUERY_ELEMENT,
              Zend_Search_Lucene_Search_QueryToken::TT_SUBQUERY_START,
              self::ST_COMMON_QUERY_ELEMENT,
            ],
            [
              self::ST_COMMON_QUERY_ELEMENT,
              Zend_Search_Lucene_Search_QueryToken::TT_SUBQUERY_END,
              self::ST_COMMON_QUERY_ELEMENT,
            ],
            [
              self::ST_COMMON_QUERY_ELEMENT,
              Zend_Search_Lucene_Search_QueryToken::TT_AND_LEXEME,
              self::ST_COMMON_QUERY_ELEMENT,
            ],
            [
              self::ST_COMMON_QUERY_ELEMENT,
              Zend_Search_Lucene_Search_QueryToken::TT_OR_LEXEME,
              self::ST_COMMON_QUERY_ELEMENT,
            ],
            [
              self::ST_COMMON_QUERY_ELEMENT,
              Zend_Search_Lucene_Search_QueryToken::TT_NOT_LEXEME,
              self::ST_COMMON_QUERY_ELEMENT,
            ],
            [
              self::ST_COMMON_QUERY_ELEMENT,
              Zend_Search_Lucene_Search_QueryToken::TT_NUMBER,
              self::ST_COMMON_QUERY_ELEMENT,
            ],
          ]
        );
        $this->addRules(
          [
            [
              self::ST_CLOSEDINT_RQ_START,
              Zend_Search_Lucene_Search_QueryToken::TT_WORD,
              self::ST_CLOSEDINT_RQ_FIRST_TERM,
            ],
            [
              self::ST_CLOSEDINT_RQ_FIRST_TERM,
              Zend_Search_Lucene_Search_QueryToken::TT_TO_LEXEME,
              self::ST_CLOSEDINT_RQ_TO_TERM,
            ],
            [
              self::ST_CLOSEDINT_RQ_TO_TERM,
              Zend_Search_Lucene_Search_QueryToken::TT_WORD,
              self::ST_CLOSEDINT_RQ_LAST_TERM,
            ],
            [
              self::ST_CLOSEDINT_RQ_LAST_TERM,
              Zend_Search_Lucene_Search_QueryToken::TT_RANGE_INCL_END,
              self::ST_COMMON_QUERY_ELEMENT,
            ],
          ]
        );
        $this->addRules(
          [
            [
              self::ST_OPENEDINT_RQ_START,
              Zend_Search_Lucene_Search_QueryToken::TT_WORD,
              self::ST_OPENEDINT_RQ_FIRST_TERM,
            ],
            [
              self::ST_OPENEDINT_RQ_FIRST_TERM,
              Zend_Search_Lucene_Search_QueryToken::TT_TO_LEXEME,
              self::ST_OPENEDINT_RQ_TO_TERM,
            ],
            [
              self::ST_OPENEDINT_RQ_TO_TERM,
              Zend_Search_Lucene_Search_QueryToken::TT_WORD,
              self::ST_OPENEDINT_RQ_LAST_TERM,
            ],
            [
              self::ST_OPENEDINT_RQ_LAST_TERM,
              Zend_Search_Lucene_Search_QueryToken::TT_RANGE_EXCL_END,
              self::ST_COMMON_QUERY_ELEMENT,
            ],
          ]
        );

        $addTermEntryAction = new Zend_Search_Lucene_FSMAction($this, 'addTermEntry');
        $addPhraseEntryAction = new Zend_Search_Lucene_FSMAction($this, 'addPhraseEntry');
        $setFieldAction = new Zend_Search_Lucene_FSMAction($this, 'setField');
        $setSignAction = new Zend_Search_Lucene_FSMAction($this, 'setSign');
        $setFuzzyProxAction = new Zend_Search_Lucene_FSMAction($this, 'processFuzzyProximityModifier');
        $processModifierParameterAction = new Zend_Search_Lucene_FSMAction($this, 'processModifierParameter');
        $subqueryStartAction = new Zend_Search_Lucene_FSMAction($this, 'subqueryStart');
        $subqueryEndAction = new Zend_Search_Lucene_FSMAction($this, 'subqueryEnd');
        $logicalOperatorAction = new Zend_Search_Lucene_FSMAction($this, 'logicalOperator');
        $openedRQFirstTermAction = new Zend_Search_Lucene_FSMAction($this, 'openedRQFirstTerm');
        $openedRQLastTermAction = new Zend_Search_Lucene_FSMAction($this, 'openedRQLastTerm');
        $closedRQFirstTermAction = new Zend_Search_Lucene_FSMAction($this, 'closedRQFirstTerm');
        $closedRQLastTermAction = new Zend_Search_Lucene_FSMAction($this, 'closedRQLastTerm');

        $this->addInputAction(
          self::ST_COMMON_QUERY_ELEMENT,
          Zend_Search_Lucene_Search_QueryToken::TT_WORD,
          $addTermEntryAction
        );
        $this->addInputAction(
          self::ST_COMMON_QUERY_ELEMENT,
          Zend_Search_Lucene_Search_QueryToken::TT_PHRASE,
          $addPhraseEntryAction
        );
        $this->addInputAction(
          self::ST_COMMON_QUERY_ELEMENT,
          Zend_Search_Lucene_Search_QueryToken::TT_FIELD,
          $setFieldAction
        );
        $this->addInputAction(
          self::ST_COMMON_QUERY_ELEMENT,
          Zend_Search_Lucene_Search_QueryToken::TT_REQUIRED,
          $setSignAction
        );
        $this->addInputAction(
          self::ST_COMMON_QUERY_ELEMENT,
          Zend_Search_Lucene_Search_QueryToken::TT_PROHIBITED,
          $setSignAction
        );
        $this->addInputAction(
          self::ST_COMMON_QUERY_ELEMENT,
          Zend_Search_Lucene_Search_QueryToken::TT_FUZZY_PROX_MARK,
          $setFuzzyProxAction
        );
        $this->addInputAction(
          self::ST_COMMON_QUERY_ELEMENT,
          Zend_Search_Lucene_Search_QueryToken::TT_NUMBER,
          $processModifierParameterAction
        );
        $this->addInputAction(
          self::ST_COMMON_QUERY_ELEMENT,
          Zend_Search_Lucene_Search_QueryToken::TT_SUBQUERY_START,
          $subqueryStartAction
        );
        $this->addInputAction(
          self::ST_COMMON_QUERY_ELEMENT,
          Zend_Search_Lucene_Search_QueryToken::TT_SUBQUERY_END,
          $subqueryEndAction
        );
        $this->addInputAction(
          self::ST_COMMON_QUERY_ELEMENT,
          Zend_Search_Lucene_Search_QueryToken::TT_AND_LEXEME,
          $logicalOperatorAction
        );
        $this->addInputAction(
          self::ST_COMMON_QUERY_ELEMENT,
          Zend_Search_Lucene_Search_QueryToken::TT_OR_LEXEME,
          $logicalOperatorAction
        );
        $this->addInputAction(
          self::ST_COMMON_QUERY_ELEMENT,
          Zend_Search_Lucene_Search_QueryToken::TT_NOT_LEXEME,
          $logicalOperatorAction
        );

        $this->addEntryAction(self::ST_OPENEDINT_RQ_FIRST_TERM, $openedRQFirstTermAction);
        $this->addEntryAction(self::ST_OPENEDINT_RQ_LAST_TERM, $openedRQLastTermAction);
        $this->addEntryAction(self::ST_CLOSEDINT_RQ_FIRST_TERM, $closedRQFirstTermAction);
        $this->addEntryAction(self::ST_CLOSEDINT_RQ_LAST_TERM, $closedRQLastTermAction);

        require_once 'Zend/Search/Lucene/Search/QueryLexer.php';
        $this->_lexer = new Zend_Search_Lucene_Search_QueryLexer();
    }

    /**
     * Current query parser context
     * @var Zend_Search_Lucene_Search_QueryParserContext
     */
    private $_context;   // Terms, phrases, operators
    /**
     * Context stack
     * @var array
     */
    private $_contextStack;   // Range query start (closed interval) - '['
    /**
     * Current token
     * @var integer|string
     */
    private $_currentToken;   // First term in '[term1 to term2]' construction
    /**
     * Query string default encoding
     * @var string
     */
    private $_defaultEncoding = '';   // 'TO' lexeme in '[term1 to term2]' construction
    /**
     * Default boolean queries operator
     * @var integer
     */
    private $_defaultOperator = self::B_OR;   // Second term in '[term1 to term2]' construction
    /**
     * Query string encoding
     * @var string
     */
    private $_encoding;   // Range query end (closed interval) - ']'
    /**
     * Last token
     * It can be processed within FSM states, but this addirional state simplifies FSM
     * @var Zend_Search_Lucene_Search_QueryToken
     */
    private $_lastToken = null;   // Range query start (opened interval) - '{'
    /**
     * Query lexer
     * @var Zend_Search_Lucene_Search_QueryLexer
     */
    private $_lexer;   // First term in '{term1 to term2}' construction
    /**
     * Range query first term
     * @var string
     */
    private $_rqFirstTerm = null;   // 'TO' lexeme in '{term1 to term2}' construction
    /**
     * Defines query parsing mode.
     * If this option is turned on, then query parser suppress query parser exceptions
     * and constructs multi-term query using all words from a query.
     * That helps to avoid exceptions caused by queries, which don't conform to query language,
     * but limits possibilities to check, that query entered by user has some inconsistencies.
     * Default is true.
     * Use {@link Zend_Search_Lucene::suppressQueryParsingExceptions()},
     * {@link Zend_Search_Lucene::dontSuppressQueryParsingExceptions()} and
     * {@link Zend_Search_Lucene::checkQueryParsingExceptionsSuppressMode()} to operate
     * with this setting.
     * @var boolean
     */
    private $_suppressQueryParsingExceptions = true;   // Second term in '{term1 to term2}' construction
    /**
     * Tokens list
     * Array of Zend_Search_Lucene_Search_QueryToken objects
     * @var array
     */
    private $_tokens;  // Range query end (opened interval) - '}'
    /**
     * Parser instance
     * @var Zend_Search_Lucene_Search_QueryParser
     */
    private static $_instance = null;

    /**
     * Add phrase to a query
     */
    public function addPhraseEntry()
    {
        require_once 'Zend/Search/Lucene/Search/QueryEntry/Phrase.php';
        $entry =
          new Zend_Search_Lucene_Search_QueryEntry_Phrase($this->_currentToken->text, $this->_context->getField());
        $this->_context->addEntry($entry);
    }

    /**
     * Add term to a query
     */
    public function addTermEntry()
    {
        require_once 'Zend/Search/Lucene/Search/QueryEntry/Term.php';
        $entry = new Zend_Search_Lucene_Search_QueryEntry_Term($this->_currentToken->text, $this->_context->getField());
        $this->_context->addEntry($entry);
    }

    /**
     * Process first range query term (closed interval)
     */
    public function closedRQFirstTerm()
    {
        $this->_rqFirstTerm = $this->_currentToken->text;
    }

    /**
     * Process last range query term (closed interval)
     * @throws Zend_Search_Lucene_Search_QueryParserException
     */
    public function closedRQLastTerm()
    {
        $tokens = Zend_Search_Lucene_Analysis_Analyzer::getDefault()->tokenize($this->_rqFirstTerm, $this->_encoding);
        if (count($tokens) > 1) {
            require_once 'Zend/Search/Lucene/Search/QueryParserException.php';
            throw new Zend_Search_Lucene_Search_QueryParserException(
              'Range query boundary terms must be non-multiple word terms'
            );
        } else {
            if (count($tokens) == 1) {
                require_once 'Zend/Search/Lucene/Index/Term.php';
                $from = new Zend_Search_Lucene_Index_Term(reset($tokens)->getTermText(), $this->_context->getField());
            } else {
                $from = null;
            }
        }

        $tokens =
          Zend_Search_Lucene_Analysis_Analyzer::getDefault()->tokenize($this->_currentToken->text, $this->_encoding);
        if (count($tokens) > 1) {
            require_once 'Zend/Search/Lucene/Search/QueryParserException.php';
            throw new Zend_Search_Lucene_Search_QueryParserException(
              'Range query boundary terms must be non-multiple word terms'
            );
        } else {
            if (count($tokens) == 1) {
                require_once 'Zend/Search/Lucene/Index/Term.php';
                $to = new Zend_Search_Lucene_Index_Term(reset($tokens)->getTermText(), $this->_context->getField());
            } else {
                $to = null;
            }
        }

        if ($from === null && $to === null) {
            require_once 'Zend/Search/Lucene/Search/QueryParserException.php';
            throw new Zend_Search_Lucene_Search_QueryParserException(
              'At least one range query boundary term must be non-empty term'
            );
        }

        require_once 'Zend/Search/Lucene/Search/Query/Range.php';
        $rangeQuery = new Zend_Search_Lucene_Search_Query_Range($from, $to, true);
        require_once 'Zend/Search/Lucene/Search/QueryEntry/Subquery.php';
        $entry = new Zend_Search_Lucene_Search_QueryEntry_Subquery($rangeQuery);
        $this->_context->addEntry($entry);
    }

    /**
     * Process logical operator
     */
    public function logicalOperator()
    {
        $this->_context->addLogicalOperator($this->_currentToken->type);
    }

    /**
     * Process first range query term (opened interval)
     */
    public function openedRQFirstTerm()
    {
        $this->_rqFirstTerm = $this->_currentToken->text;
    }

    /**
     * Process last range query term (opened interval)
     * @throws Zend_Search_Lucene_Search_QueryParserException
     */
    public function openedRQLastTerm()
    {
        $tokens = Zend_Search_Lucene_Analysis_Analyzer::getDefault()->tokenize($this->_rqFirstTerm, $this->_encoding);
        if (count($tokens) > 1) {
            require_once 'Zend/Search/Lucene/Search/QueryParserException.php';
            throw new Zend_Search_Lucene_Search_QueryParserException(
              'Range query boundary terms must be non-multiple word terms'
            );
        } else {
            if (count($tokens) == 1) {
                require_once 'Zend/Search/Lucene/Index/Term.php';
                $from = new Zend_Search_Lucene_Index_Term(reset($tokens)->getTermText(), $this->_context->getField());
            } else {
                $from = null;
            }
        }

        $tokens =
          Zend_Search_Lucene_Analysis_Analyzer::getDefault()->tokenize($this->_currentToken->text, $this->_encoding);
        if (count($tokens) > 1) {
            require_once 'Zend/Search/Lucene/Search/QueryParserException.php';
            throw new Zend_Search_Lucene_Search_QueryParserException(
              'Range query boundary terms must be non-multiple word terms'
            );
        } else {
            if (count($tokens) == 1) {
                require_once 'Zend/Search/Lucene/Index/Term.php';
                $to = new Zend_Search_Lucene_Index_Term(reset($tokens)->getTermText(), $this->_context->getField());
            } else {
                $to = null;
            }
        }

        if ($from === null && $to === null) {
            require_once 'Zend/Search/Lucene/Search/QueryParserException.php';
            throw new Zend_Search_Lucene_Search_QueryParserException(
              'At least one range query boundary term must be non-empty term'
            );
        }

        require_once 'Zend/Search/Lucene/Search/Query/Range.php';
        $rangeQuery = new Zend_Search_Lucene_Search_Query_Range($from, $to, false);
        require_once 'Zend/Search/Lucene/Search/QueryEntry/Subquery.php';
        $entry = new Zend_Search_Lucene_Search_QueryEntry_Subquery($rangeQuery);
        $this->_context->addEntry($entry);
    }

    /**
     * Process fuzzy search/proximity modifier - '~'
     */
    public function processFuzzyProximityModifier()
    {
        $this->_context->processFuzzyProximityModifier();
    }

    /**
     * Process modifier parameter
     * @throws Zend_Search_Lucene_Exception
     */
    public function processModifierParameter()
    {
        if ($this->_lastToken === null) {
            require_once 'Zend/Search/Lucene/Search/QueryParserException.php';
            throw new Zend_Search_Lucene_Search_QueryParserException(
              'Lexeme modifier parameter must follow lexeme modifier. Char position 0.'
            );
        }

        switch ($this->_lastToken->type) {
            case Zend_Search_Lucene_Search_QueryToken::TT_FUZZY_PROX_MARK:
                $this->_context->processFuzzyProximityModifier($this->_currentToken->text);
                break;

            case Zend_Search_Lucene_Search_QueryToken::TT_BOOSTING_MARK:
                $this->_context->boost($this->_currentToken->text);
                break;

            default:
                // It's not a user input exception
                require_once 'Zend/Search/Lucene/Exception.php';
                throw new Zend_Search_Lucene_Exception(
                  'Lexeme modifier parameter must follow lexeme modifier. Char position 0.'
                );
        }
    }

    /**
     * Set entry field
     */
    public function setField()
    {
        $this->_context->setNextEntryField($this->_currentToken->text);
    }

    /*********************************************************************
     * Actions implementation
     * Actions affect on recognized lexemes list
     *********************************************************************/

    /**
     * Set entry sign
     */
    public function setSign()
    {
        $this->_context->setNextEntrySign($this->_currentToken->type);
    }

    /**
     * End subquery
     */
    public function subqueryEnd()
    {
        if (count($this->_contextStack) == 0) {
            require_once 'Zend/Search/Lucene/Search/QueryParserException.php';
            throw new Zend_Search_Lucene_Search_QueryParserException(
              'Syntax Error: mismatched parentheses, every opening must have closing. Char position ' .
              $this->_currentToken->position .
              '.'
            );
        }

        $query = $this->_context->getQuery();
        $this->_context = array_pop($this->_contextStack);

        require_once 'Zend/Search/Lucene/Search/QueryEntry/Subquery.php';
        $this->_context->addEntry(new Zend_Search_Lucene_Search_QueryEntry_Subquery($query));
    }

    /**
     * Start subquery
     */
    public function subqueryStart()
    {
        require_once 'Zend/Search/Lucene/Search/QueryParserContext.php';

        $this->_contextStack[] = $this->_context;
        $this->_context =
          new Zend_Search_Lucene_Search_QueryParserContext($this->_encoding, $this->_context->getField());
    }

    /**
     * Get query parser instance
     * @return Zend_Search_Lucene_Search_QueryParser
     */
    private static function _getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Turn off 'suppress query parser exceptions' mode.
     */
    public static function dontSuppressQueryParsingExceptions()
    {
        self::_getInstance()->_suppressQueryParsingExceptions = false;
    }

    /**
     * Escape keyword to force it to be parsed as one term
     * @param string $keyword
     * @return string
     */
    public static function escape($keyword)
    {
        return '\\' . implode('\\', str_split($keyword));
    }

    /**
     * Get query string default encoding
     * @return string
     */
    public static function getDefaultEncoding()
    {
        return self::_getInstance()->_defaultEncoding;
    }

    /**
     * Get default boolean operator
     * @return integer
     */
    public static function getDefaultOperator()
    {
        return self::_getInstance()->_defaultOperator;
    }

    /**
     * Parses a query string
     * @param string $strQuery
     * @param string $encoding
     * @return Zend_Search_Lucene_Search_Query
     * @throws Zend_Search_Lucene_Search_QueryParserException
     */
    public static function parse($strQuery, $encoding = null)
    {
        self::_getInstance();

        // Reset FSM if previous parse operation didn't return it into a correct state
        self::$_instance->reset();

        require_once 'Zend/Search/Lucene/Search/QueryParserException.php';
        try {
            require_once 'Zend/Search/Lucene/Search/QueryParserContext.php';

            self::$_instance->_encoding = ($encoding !== null) ? $encoding : self::$_instance->_defaultEncoding;
            self::$_instance->_lastToken = null;
            self::$_instance->_context = new Zend_Search_Lucene_Search_QueryParserContext(self::$_instance->_encoding);
            self::$_instance->_contextStack = [];
            self::$_instance->_tokens = self::$_instance->_lexer->tokenize($strQuery, self::$_instance->_encoding);

            // Empty query
            if (count(self::$_instance->_tokens) == 0) {
                require_once 'Zend/Search/Lucene/Search/Query/Insignificant.php';
                return new Zend_Search_Lucene_Search_Query_Insignificant();
            }

            foreach (self::$_instance->_tokens as $token) {
                try {
                    self::$_instance->_currentToken = $token;
                    self::$_instance->process($token->type);

                    self::$_instance->_lastToken = $token;
                } catch (Exception $e) {
                    if (strpos($e->getMessage(), 'There is no any rule for') !== false) {
                        throw new Zend_Search_Lucene_Search_QueryParserException(
                          'Syntax error at char position ' . $token->position . '.',
                          0,
                          $e
                        );
                    }

                    require_once 'Zend/Search/Lucene/Exception.php';
                    throw new Zend_Search_Lucene_Exception($e->getMessage(), $e->getCode(), $e);
                }
            }

            if (count(self::$_instance->_contextStack) != 0) {
                throw new Zend_Search_Lucene_Search_QueryParserException(
                  'Syntax Error: mismatched parentheses, every opening must have closing.'
                );
            }

            return self::$_instance->_context->getQuery();
        } catch (Zend_Search_Lucene_Search_QueryParserException $e) {
            if (self::$_instance->_suppressQueryParsingExceptions) {
                $queryTokens =
                  Zend_Search_Lucene_Analysis_Analyzer::getDefault()->tokenize($strQuery, self::$_instance->_encoding);

                require_once 'Zend/Search/Lucene/Search/Query/MultiTerm.php';
                $query = new Zend_Search_Lucene_Search_Query_MultiTerm();
                $termsSign = (self::$_instance->_defaultOperator == self::B_AND) ? true /* required term */ :
                  null /* optional term */
                ;

                require_once 'Zend/Search/Lucene/Index/Term.php';
                foreach ($queryTokens as $token) {
                    $query->addTerm(new Zend_Search_Lucene_Index_Term($token->getTermText()), $termsSign);
                }

                return $query;
            } else {
                require_once 'Zend/Search/Lucene/Exception.php';
                throw new Zend_Search_Lucene_Exception($e->getMessage(), $e->getCode(), $e);
            }
        }
    }

    /**
     * Check 'suppress query parser exceptions' mode.
     * @return boolean
     */
    public static function queryParsingExceptionsSuppressed()
    {
        return self::_getInstance()->_suppressQueryParsingExceptions;
    }

    /**
     * Set query string default encoding
     * @param string $encoding
     */
    public static function setDefaultEncoding($encoding)
    {
        self::_getInstance()->_defaultEncoding = $encoding;
    }

    /**
     * Set default boolean operator
     * @param integer $operator
     */
    public static function setDefaultOperator($operator)
    {
        self::_getInstance()->_defaultOperator = $operator;
    }

    /**
     * Turn on 'suppress query parser exceptions' mode.
     */
    public static function suppressQueryParsingExceptions()
    {
        self::_getInstance()->_suppressQueryParsingExceptions = true;
    }
}

