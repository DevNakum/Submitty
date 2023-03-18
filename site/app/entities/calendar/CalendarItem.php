<?php

declare(strict_types=1);

namespace app\entities\calendar;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="calendar_messages")
 */
class CalendarItem {
    // Note the 'Important' type is also treated as regular text
    const TEXT = 0;
    const ANNOUNCEMENT = 1;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $type;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $text;

    /**
     * @ORM\Column(type="date")
     * @var DateTime
     */
    protected $date;

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    public function isAnnouncement(): bool {
        return $this->type === self::ANNOUNCEMENT;
    }

    public function isText(): bool {
        return $this->type === self::TEXT;
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getText(): string {
        return $this->text;
    }

    /**
     * @param DateTime $date
     */
    public function setDate(DateTime $date): void {
        $this->date = $date;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void {
        if (strlen($text) > 255) {
            throw new \InvalidArgumentException();
        }
        $this->text = $text;
    }

    /**
     * @param int $type Takes in either 0 or 1
     */
    public function setType(int $type): void {
        if ($type === self::ANNOUNCEMENT || $type === self::TEXT) {
            $this->type = $type;
        }
        throw new \InvalidArgumentException();
    }

    /**
     * @param string $type
     */
    public function setStringType(string $type): void {
        switch ($type) {
            case 'note':
                $this->type = self::TEXT;
                break;
            case 'important':
                $this->type = self::TEXT;
                break;
            case 'announcement':
                $this->type = self::ANNOUNCEMENT;
                break;
            default:
                throw new \InvalidArgumentException();
        }
    }

    /**
     * @return int 1 for ANNOUNCEMENT and 0 for TEXT
     */
    public function getType(): int {
        return $this->type;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getTypeString(): string {
        switch ($this->type) {
            case self::TEXT:
                return 'text';
            case self::ANNOUNCEMENT:
                return 'ann';
        }
        throw new \Exception();
    }
}
