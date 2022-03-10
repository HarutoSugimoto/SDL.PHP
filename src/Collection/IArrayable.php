<?php
namespace Jp\Skud\Sdl\Collection;

/**
 * 配列化可能なオブジェクトに関する機能を提供するインタフェース
 */
interface IArrayable
{
    // ================================================================
    // 抽象関数
    // ================================================================
    /**
     * 配列に変換する。
     *
     * @return array
     */
    public function toArray() : array;
}