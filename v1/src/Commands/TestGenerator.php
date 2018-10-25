<?php

namespace Flexe\Commands;

use Flexe\Db\Init;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class TestGenerator extends Command
{
    use TraitCommands;

    /**
     * @var Init
     */
    private $init;

    public function __construct(Init $init =null)
    {

        parent::__construct();
        $this->init = $init;

    }

    protected function configure()
    {
        $this
            ->setName('test')
            ->setDescription('Cria uma classe model')
            ->setHelp('Altere o template para refletir a alteração')
             ->addArgument('table', InputArgument::REQUIRED, 'O app name do controller');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {


        $this->Default =$input->getArgument('table');
        if($this->init):

            $query = $this->init->from($this->Default);

            var_dump($this->getTo($query->execute()));

        endif;

        $output->write("Passou");
    }

    public function getTo(\PDOStatement $statement)
    {
        $rows = [];

        for ($i = 0; ($columnMeta = $statement->getColumnMeta($i)) !== false; $i++)
        {
           var_dump($columnMeta);


        }
        return implode("','",$rows);
    }
}
