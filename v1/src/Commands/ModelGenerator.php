<?php

namespace Flexe\Commands;

use Flexe\Db\Init;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class ModelGenerator extends Command
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
            ->setName('model')
            ->setDescription('Cria uma classe model')
            ->setHelp('Altere o template para refletir a alteração')
            ->addArgument('vendor', InputArgument::REQUIRED, 'O vendor name da classe e obrigatorio ex:src')
            ->addArgument('app', InputArgument::REQUIRED, 'O app namespace da classe e obrigatorio')
            ->addArgument('module', InputArgument::REQUIRED, 'O module name da classe e obrigatorio ex:Admin')
            ->addArgument('controller', InputArgument::REQUIRED, 'O app name do controller');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {


        $this->Default = [
            "S_App" => $this->filteredName($input->getArgument('app')),
            "S_Parent" => $this->filteredName($input->getArgument('module')),
            "S_Demo" => $this->filteredName($input->getArgument('controller')),
            "S_controller" => $input->getArgument('controller'),
            "S_table" => $input->getArgument('controller'),
            "S_route" => str_slug($input->getArgument('module'))
        ];
        if($this->init):

            $query = $this->init->from(sprintf("%ss", $input->getArgument('controller')));

            $this->Default['S_fillable'] = $this->getToNativeNames($query->execute());

        endif;
        $vendor_directory =sprintf("%s/%s",ROOT,$input->getArgument('vendor'));

        $module_directory =sprintf("%s/%s",$vendor_directory,$this->filteredName($input->getArgument('module')));

        $directory_controller =sprintf("%s/Model",$module_directory);
        $continua = true;

        if (!is_dir($vendor_directory)):

            $continua = mkdir($vendor_directory);

            $error = "O caminho para o diretorio vendor [ {$vendor_directory} ] não foi encontrado!!";

        endif;

        if($continua):

            if (!is_dir($module_directory)):

                $continua = mkdir($module_directory);
                $error = "O caminho para o diretorio module [ {$vendor_directory} ] não foi encontrado!!";

            endif;

        endif;

        if($continua):

            if (!is_dir($directory_controller)):

                $continua = mkdir($directory_controller);
                $error = "O caminho para o diretorio module [ {$directory_controller} ] não foi encontrado!!";

            endif;

        endif;

        if (!is_dir($directory_controller)):

            if(!mkdir($directory_controller)):

                $continua = false;

            endif;
        endif;

        if ($continua) {

            $this->aFind = array_keys($this->Default);

            $this->aSub = array_values($this->Default);

            $template = file_get_contents(sprintf("%s/data/template/Model", ROOT));

            $template = str_replace($this->aFind, $this->aSub, $template);


            file_put_contents(sprintf("%s/%sModel.php", $directory_controller, $this->filteredName($input->getArgument('controller'))), $template);

            $error =$template;
        }

        $output->write($error);
    }


}
