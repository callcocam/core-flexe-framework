<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 09/10/2018
 * Time: 14:17
 */

namespace Flexe\Plugins\Excel;


use Box\Spout\Common\Exception\IOException;
use Box\Spout\Common\Exception\UnsupportedTypeException;
use Box\Spout\Reader\Exception\ReaderNotOpenedException;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Reader\ReaderInterface;
use Box\Spout\Reader\SheetInterface;

trait Importable
{
    /**
     * @var int
     */
    private $sheet_number = 1;

    /**
     * @param string $path
     *
     * @return string
     */
    abstract protected function getType($path);

    /**
     * @param ReaderInterface|\Box\Spout\Writer\WriterInterface $reader_or_writer
     *
     * @return mixed
     */
    abstract protected function setOptions(&$reader_or_writer);

    /**
     * @param string        $path
     * @param callable|null $callback
     *
     * @throws IOException
     * @throws UnsupportedTypeException
     * @throws ReaderNotOpenedException
     *
     * @return Collection
     */
    public function import($path, callable $callback = null)
    {
        $reader = $this->reader($path);

        foreach ($reader->getSheetIterator() as $key => $sheet) {
            if ($this->sheet_number != $key) {
                continue;
            }
            $collection = $this->importSheet($sheet, $callback);
        }
        $reader->close();

        return collect($collection ?? []);
    }

    /**
     * @param string        $path
     * @param callable|null $callback
     *
     * @throws IOException
     * @throws UnsupportedTypeException
     * @throws ReaderNotOpenedException
     *
     * @return Collection
     */
    public function importSheets($path, callable $callback = null)
    {
        $reader = $this->reader($path);

        $collections = [];
        foreach ($reader->getSheetIterator() as $key => $sheet) {
            $collections[] = $this->importSheet($sheet, $callback);
        }
        $reader->close();

        return new SheetCollection($collections);
    }

    /**
     * @param $path
     *
     * @throws IOException
     * @throws UnsupportedTypeException
     *
     * @return ReaderInterface
     */
    private function reader($path)
    {
        $reader = ReaderFactory::create($this->getType($path));
        $this->setOptions($reader);
        /* @var ReaderInterface $reader */
        $reader->open($path);

        return $reader;
    }

    /**
     * @param SheetInterface $sheet
     * @param callable|null  $callback
     *
     * @return array
     */
    private function importSheet(SheetInterface $sheet, callable $callback = null)
    {
        $headers = [];
        $collection = [];
        $count_header = 0;

        if ($this->with_header) {
            foreach ($sheet->getRowIterator() as $k => $row) {
                if ($k == 1) {
                    $headers = $row;
                    $count_header = count($headers);
                    continue;
                }
                if ($count_header > $count_row = count($row)) {
                    $row = array_merge($row, array_fill(0, $count_header - $count_row, null));
                } elseif ($count_header < $count_row = count($row)) {
                    $row = array_slice($row, 0, $count_header);
                }
                $collection[] = $callback ? $callback(array_combine($headers, $row)) : array_combine($headers, $row);
            }
        } else {
            foreach ($sheet->getRowIterator() as $row) {
                $collection[] = $row;
            }
        }

        return $collection;
    }
}