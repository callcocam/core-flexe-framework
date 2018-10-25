<?php

namespace Flexe\Plugins\Fullcalendar;

/**
 * Class Fullcalendar
 * @package Edofre\Fullcalendar
 */
class AbstractCalendar
{
    protected $view;
    /** @var string */
    protected $id = 'fullcalendar';
    /** @var array */
    protected $events = [];
    /** @var array */
    protected $defaultOptions = [
        'header'   => [
            'left'   => 'prev,next today',
            'center' => 'title',
            'right'  => 'month,agendaWeek,agendaDay',
        ],
        'firstDay' => 1,
    ];
    /** @var array */
    protected $clientOptions = [];

    public function __construct()
    {
        $this->view = new View();
    }

    /**
     * Renders the view that includes the script files
     * @return View
     */
    public function renderScriptFiles()
    {
        return $this->view->render('files', [
            'include_gcal' => false,
        ]);
    }

    /**
     * @return string
     */
    public function generate()
    {
        return $this->calendar() . $this->script();
    }

    /**
     * Create the <div> the calendar will be rendered into
     * @return string
     */
    private function calendar()
    {
        return "<div id='" . $this->getId() . "'></div>";
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get the <script> block to render the calendar
     * @return View
     */
    private function script()
    {
        $options = [
            'id'              => $this->getId(),
            'options'         => $this->getOptionsJson(),
            'include_scripts' => true,
            'include_gcal'    => false,
        ];

        file_put_contents(sprintf("%s/%s/%s/_cdn/plugins/fullcalendar-3.9.0/config.json",
            __APP_DIR__,
            config("paths.public"),
            config("files.path")
        ), json_encode($options));

        return $this->view->render('scripts', [
            'id'              => $this->getId(),
            'options'         => $this->getOptionsJson(),
            'include_scripts' => true,
            'include_gcal'    => false,
        ]);
    }

    /**
     * @return string
     */
    public function getOptionsJson()
    {
        $options = $this->getOptions();

        if (!isset($options['events'])) {
            $options['events'] = $this->events;
        }

        // Encode the JSON properly to format the callbacks
        return JsonEncoder::encode($options);
    }


    /**
     * Get the fullcalendar options (not including the events list)
     * @return array
     */
    public function getOptions()
    {
        return array_merge($this->defaultOptions, $this->clientOptions);
    }


    /**
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->clientOptions = $options;
    }

    /**
     * @return array
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param mixed $events
     */
    public function setEvents($events)
    {
        $this->events = $events;
    }
}