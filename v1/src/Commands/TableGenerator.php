<?php

namespace Flexe\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class TableGenerator extends Command
{
    use TraitCommands;

    protected function configure()
    {
        $this
            ->setName('table')
            ->setDescription('Cria uma classe table')
            ->setHelp('Altere o template para refletir a alteração')
            ->addArgument('vendor', InputArgument::REQUIRED, 'O vendor name da classe e obrigatorio')
            ->addArgument('app', InputArgument::REQUIRED, 'O app namespace da classe e obrigatorio')
            ->addArgument('module', InputArgument::REQUIRED, 'O module name da classe e obrigatorio')
            ->addArgument('controller', InputArgument::REQUIRED, 'O controller name da classe e obrigatorio')
            ->addArgument('name', InputArgument::REQUIRED, 'O app name da classe e obrigatorio');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->Default = [
            "S_Name"        => $this->filteredName($input->getArgument('name')),
            "S_App"         => $this->filteredName($input->getArgument('app')),
            "S_Parent"      => $this->filteredName($input->getArgument('module')),
            "S_Demo"        => $this->filteredName($input->getArgument('controller')),
            "S_table"       => $input->getArgument('controller')
        ];

        $vendor_directory =sprintf("%s/%s",ROOT,$input->getArgument('vendor'));

        $module_directory =sprintf("%s/%s",$vendor_directory,$this->filteredName($input->getArgument('module')));

        $directory_table =sprintf("%s/Table",$module_directory);
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

            if (!is_dir($directory_table)):

                $continua = mkdir($directory_table);
                $error = "O caminho para o diretorio module [ {$directory_table} ] não foi encontrado!!";

            endif;

        endif;

        if (!is_dir($directory_table)):

            if(!mkdir($directory_table)):

                $continua = false;

            endif;
        endif;

        if ($continua) {

            $this->aFind = array_keys($this->Default);

            $this->aSub = array_values($this->Default);

            $template = file_get_contents(sprintf("%s/data/template/Table", ROOT));

            $template = str_replace($this->aFind, $this->aSub, $template);


            file_put_contents(sprintf("%s/%sTable.php", $directory_table, $this->filteredName($input->getArgument('controller'))), $template);

            $error =$template;
        }

        $output->write($error);
    }
}
