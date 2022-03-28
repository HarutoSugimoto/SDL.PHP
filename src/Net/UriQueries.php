<?php
namespace Jp\Skud\Sdl\Net;

use ArrayAccess;
use Jp\Skud\Sdl\Collection\Collection;
use Jp\Skud\Sdl\DateTime;
use Countable;
use IteratorAggregate;
use Jp\Skud\Sdl\Collection\IReadonlyCollection;
use Jp\Skud\Sdl\Text\StringUtil;
use Stringable;
use Traversable;

/**
 * クエリパラメタの集合を取扱うクラス。
 */
class UriQueries implements ArrayAccess, Countable, IteratorAggregate, Stringable
{
    // ================================================================
    // 変数
    // ================================================================
    /** @var Collection クエリパラメタの集合 */
    protected Collection $queries;






    // ================================================================
    // 関数
    // ================================================================
    /**
     * コンストラクタ
     *
     * @param iterable $queries
     */
    public function __construct(iterable $queries = [])
    {
        $collection = null;

        if($queries instanceof Collection)
        {
            $collection = $queries;
        }
        else
        {
            $collection = new Collection($queries);
        }

        $this->queries = $collection;
    }




    /**
     * クエリパラメタが存在するか判定する。
     *
     * @param string $key
     * @return bool
     */
    public function containsKey(string $key) : bool
    {
        return $this->queries->containsKey($key);
    }




    /**
     * クエリパラメタに値が存在するか判定する。
     *
     * @param string|array $value
     * @return bool
     */
    public function containsValue(string|array $value) : bool
    {
        return $this->queries->containsValue($value);
    }




    /**
     * クエリパラメタの集合を取得する。
     *
     * @return IReadonlyCollection
     */
    public function queries() : IReadonlyCollection
    {
        return $this->queries;
    }




    /**
     * 指定したクエリパラメタを取得する。
     *
     * @param string $key
     * @return string|array
     */
    public function get(string $key) : string|array
    {
        return $this->queries->get($key);
    }




    /**
     * 指定したクエリパラメタを取得する。
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function tryGet(string $key, mixed $default = null) : string|array|null
    {
        return $this->queries->tryGet($key, $default);
    }




    /**
     * 指定したクエリパラメタを文字列として取得する。
     *
     * @param string $key
     * @param string $default
     * @return string
     */
    public function getAsString(string $key, string $default = '') : string
    {
        return (string)$this->queries->tryGet($key, $default);
    }




    /**
     * 指定したクエリパラメタを整数として取得する。
     *
     * @param string $key
     * @param int $default
     * @return int
     */
    public function getAsInteger(string $key, int $default = 0) : int
    {
        return (int)$this->queries->tryGet($key, $default);
    }




    /**
     * 指定したクエリパラメタを浮動小数点数型数値として取得する。
     *
     * @param string $key
     * @param float $default
     * @return float
     */
    public function getAsFloat(string $key, float $default = 0) : float
    {
        return (float)$this->queries->tryGet($key, $default);
    }




    /**
     * 指定したクエリパラメタを論理値として取得する。
     *
     * @param string $key
     * @param bool $default
     * @return bool
     */
    public function getAsBool(string $key, bool $default = false) : bool
    {
        return (bool)$this->queries->tryGet($key, $default);
    }




    /**
     * 指定したクエリパラメタを配列として取得する。
     *
     * @param string $key
     * @param array $default
     * @return array
     */
    public function getAsArray(string $key, array $default = []) : array
    {
        return (array)$this->queries->tryGet($key, $default);
    }




    /**
     * 指定したクエリパラメタをDateTime値として取得する。
     *
     * @param string $key
     * @param DateTime|null $default
     * @return DateTime
     */
    public function getAsDateTime(string $key, ?DateTime $default = null) : DateTime
    {
        if($default === null)
        {
            $default = DateTime::now();
        }

        $value = $this->getAsString($key);

        if(StringUtil::isEmpty($value))
        {
            return $default;
        }

        return new DateTime($value);
    }




    /**
     * クエリパラメタを追加する。
     *
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public function add(string $key, mixed $value) : self
    {
        $this->queries->add((string)$value, $key);
        return $this;
    }




    /**
     * クエリパラメタを追加する。
     *
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public function tryAdd(string $key, mixed $value) : bool
    {
        return $this->queries->tryAdd($value, (string)$value);
    }




    /**
     * クエリパラメタを設定する。
     *
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public function set(string $key, mixed $value) : self
    {
        $this->queries->setElement($key, (string)$value);
        return $this;
    }




    /**
     * クエリパラメタを削除する。
     *
     * @param string $key
     * @return self
     */
    public function remove(string $key) : self
    {
        $this->queries->remove($key);
        return $this;
    }




    /**
     * クエリパラメタを削除する。
     *
     * @param string $key
     * @return bool
     */
    public function tryRemove(string $key) : bool
    {
        return $this->queries->tryRemove($key);
    }




    /**
     * パラメタの集合を配列に変換する。
     *
     * @return string[]
     */
    public function toArray() : array
    {
        return $this->queries->toArray();
    }




    /**
     * パラメタの集合をクエリストリングに変換する。
     * ※先頭に"?"は付与されない。
     *
     * @return string
     */
    public function toString() : string
    {
        return http_build_query($this->toArray());
    }




    /**
     * @inheritdoc
     */
    public function offsetExists(mixed $offset): bool
    {
        return $this->queries->offsetExists($offset);
    }




    /**
     * @inheritdoc
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->queries->offsetGet($offset);
    }




    /**
     * @inheritdoc
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->queries->offsetSet($offset, $value);
    }




    /**
     * @inheritdoc
     */
    public function offsetUnset(mixed $offset): void
    {
        $this->queries->offsetUnset($offset);
    }




    /**
     * @inheritdoc
     */
    public function count(): int
    {
        return $this->queries->count();
    }




    /**
     * @inheritdoc
     */
    public function getIterator(): Traversable
    {
        return $this->queries->getIterator();
    }




    /**
     * @inheritdoc
     */
    public function __toString(): string
    {
        return $this->toString();
    }






    // ================================================================
    // 静的関数
    // ================================================================
    /**
     * クエリ文字列を解析する。
     *
     * @param string $queryString
     * @return self
     */
    public static function parseQueryString(string $queryString) : self
    {
        $queries = [];
        parse_str($queryString, $queries);
        return new self($queries);
    }
}
