<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 09/10/2018
 * Time: 14:13
 */

namespace Flexe\Plugins\Excel;


use Box\Spout\Common\Exception\InvalidArgumentException;
use Box\Spout\Common\Exception\IOException;
use Box\Spout\Common\Exception\UnsupportedTypeException;
use Box\Spout\Reader\ReaderInterface;
use Box\Spout\Writer\Exception\InvalidSheetNameException;
use Box\Spout\Writer\Exception\WriterNotOpenedException;
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Writer\WriterInterface;
use Illuminate\Support\Collection;

trait Exportable
{
    /**
     * @param string $path
     *
     * @return string
     */
    abstract protected function getType($path);

    /**
     * @param ReaderInterface|WriterInterface $reader_or_writer
     *
     * @return mixed
     */
    abstract protected function setOptions(&$reader_or_writer);

    /**
     * @param string $path
     * @param callable|null $callback
     *
     * @return string
     * @throws IOException
     * @throws InvalidArgumentException
     * @throws UnsupportedTypeException
     * @throws WriterNotOpenedException
     * @throws \Box\Spout\Common\Exception\SpoutException
     */
    public function export($path, callable $callback = null)
    {
        self::exportOrDownload($path, 'openToFile', $callback);

        return realpath($path) ?: $path;
    }

    /**
     * @param $path
     * @param callable|null $callback
     *
     * @return string
     * @throws IOException
     * @throws InvalidArgumentException
     * @throws UnsupportedTypeException
     * @throws WriterNotOpenedException
     * @throws \Box\Spout\Common\Exception\SpoutException
     */
    public function download($path, callable $callback = null)
    {
        if (method_exists(response(), 'streamDownload')) {
            return response()->streamDownload(function () use ($path, $callback) {
                self::exportOrDownload($path, 'openToBrowser', $callback);
            });
        }
        self::exportOrDownload($path, 'openToBrowser', $callback);

        return '';
    }

    /**
     * @param $path
     * @param string $function
     * @param callable|null $callback
     *
     * @throws UnsupportedTypeException
     * @throws WriterNotOpenedException
     * @throws InvalidSheetNameException
     */
    private function exportOrDownload($path, $function, callable $callback = null)
    {
        $writer = WriterFactory::create($this->getType($path));
        $this->setOptions($writer);
        /* @var WriterInterface $writer */
        $writer->$function($path);

        $has_sheets = ($writer instanceof \Box\Spout\Writer\XLSX\Writer || $writer instanceof \Box\Spout\Writer\ODS\Writer);

        // It can export one sheet (Collection) or N sheets (SheetCollection)
        $data = $this->data instanceof SheetCollection ? $this->data : collect([$this->data]);

        foreach ($data as $key => $collection) {

            if ($collection instanceof Collection) {
                // Apply callback
                if ($callback) {
                    $collection->transform(function ($value) use ($callback) {
                        return $callback($value);
                    });
                }
                // Prepare collection (i.e remove non-string)
                $this->prepareCollection();
                // Add header row.
                if ($this->with_header) {
                    $first_row = $collection->first();
                    $keys = array_keys(is_array($first_row) ? $first_row : $first_row->toArray());
                    $writer->addRow($keys);
                }
                $writer->addRows($collection->toArray());
            }

            if (is_string($key)) {
                $writer->getCurrentSheet()->setName($key);
            }

       if ($has_sheets && $data->keys()->last() !== $key) {
                $writer->addNewSheetAndMakeItCurrent();
            }
        }
        $writer->close();
    }

    /**
     * Prepare collection by removing non string if required.
     */
    protected function prepareCollection()
    {
        $need_conversion = false;
        $first_row = $this->data;

        if (!$first_row) {
            return;
        }

        foreach ($first_row as $item) {
            if (!is_string($item)) {
                $need_conversion = true;
            }
        }
        if ($need_conversion) {
            $this->transform();
        }
    }

    /**
     * Transform the collection.
     */
    private function transform()
    {
        $this->data->transform(function ($data) {
            return collect($data)->map(function ($value) {
                return is_int($value) || is_float($value) || is_null($value) ? (string) $value : $value;
            })->filter(function ($value) {
                return is_string($value);
            });
        });
    }
}