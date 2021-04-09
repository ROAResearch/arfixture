<?php

namespace roaresearch\yii2\arfixture\loggers;

use Yii;
use yii\helpers\Console;

/**
 * @author Angel (Faryshta) Guevara <angeldelcaos@gmail.com>
 */
class ConsoleLogger extends \yii\base\Component implements LoggerInterface
{
    /**
     * @var bool if the logger must show error messages only.
     * @see [[getSilent()]]
     * @see [[setSilent()]]
     */
    private bool $silent = false;

    /**
     * @var string character to call attention on a failed test.
     */
    public ?string $exclamation;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->exclamation ??= Console::ansiFormat('!', [
            Console::FG_GREEN,
            Console::BG_RED
        ]);
    }

    /**
     * @inheritdoc
     */
    public function setSilent(bool $silent)
    {
        $this->silent = $silent;
    }

    /**
     * @inheritdoc
     */
    public function getSilent(): bool
    {
        return $silent;
    }

    /**
     * @inheritdoc
     */
    public function notify(string $message, array $args = [])
    {
        !$this->silent ?: Console::output(Yii::t(
            'yii',
            $message,
            $args
        ));
    }

    /**
     * @inheritdoc
     */
    public function error(string $message, array $args = [])
    {
        Console::error(Yii::t(
            'yii',
            $message,
            $args
        ) . $this->exclamation);
    }

    /**
     * @inheritdoc
     */
    public function formatClass(string $class): string
    {
        return Console::ansiFormat($class, [Console::FG_CYAN]);
    }

    /**
     * @inheritdoc
     */
    public function formatAlias(string $alias): string
    {
        return Console::ansiFormat($alias, [Console::FG_BLUE]);
    }

    /**
     * @inheritdoc
     */
    public function formatAttribute(string $attribute): string
    {
        return Console::ansiFormat($attribute, [Console::FG_YELLOW]);
    }

    /**
     * @inheritdoc
     */
    public function formatMessage(string $message): string
    {
        return Console::ansiFormat($message, [Console::FG_PURPLE]);
    }

    /**
     * @inheritdoc
     */
    public function startFixture(array $args = [])
    {
        $this->notify(self::MESSAGE_START_FIXTURE, $args);
    }

    /**
     * @inheritdoc
     */
    public function savedRecord(array $args = [])
    {
        $this->notify(self::MESSAGE_SAVED_RECORD, $args);
    }

    /**
     * @inheritdoc
     */
    public function checkValidation(array $args = [])
    {
        $this->notify(self::MESSAGE_CHECK_VALIDATION, $args);
    }

    /**
     * @inheritdoc
     */
    public function validationCorrect(array $args = [])
    {
        $this->notify(self::MESSAGE_VALIDATION_CORRECT, $args);
    }

    /**
     * @inheritdoc
     */
    public function finishFixture(array $args = [])
    {
        $this->notify(self::MESSAGE_FINISH_FIXTURE, $args);
    }

    /**
     * @inheritdoc
     */
    public function saveException(array $args = [])
    {
        $this->error(self::ERROR_SAVE_EXCEPTION, $args);
    }

    /**
     * @inheritdoc
     */
    public function validationErrorNotFound(array $args = [])
    {
        $this->error(self::ERROR_VALIDATION_ERROR_NOT_FOUND, $args);
    }

    /**
     * @inheritdoc
     */
    public function validationMessageNotFound(array $args = [])
    {
        $this->error(self::ERROR_VALIDATION_MESSAGE_NOT_FOUND, $args);
    }

    /**
     * @inheritdoc
     */
    public function validationUnexpected(array $args = [])
    {
        $this->error(self::ERROR_VALIDATION_UNEXCPECTED, $args);
    }
}
