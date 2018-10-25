<?php

namespace Flexe\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class RouteGenerator extends Command
{
    use TraitCommands;

    protected function configure()
    {
        $this
            ->setName('route')
            ->setDescription('Cria uma classe route')
            ->setHelp('Altere o template para refletir a alteração')
            ->addArgument('vendor', InputArgument::REQUIRED, 'O vendor name da classe e obrigatorio ex:src')
            ->addArgument('app', InputArgument::REQUIRED, 'O app namespace da classe e obrigatorio')
            ->addArgument('module', InputArgument::REQUIRED, 'O module name da classe e obrigatorio ex:Admin')
            ->addArgument('controller', InputArgument::REQUIRED, 'O app name do controller')
            ->addArgument('icon');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->Default = [
            "S_App" => $this->filteredName($input->getArgument('app')),
            "S_Parent" => $this->filteredName($input->getArgument('module')),
            "S_Demo" => $this->filteredName($input->getArgument('controller')),
            "S_controller" => $input->getArgument('controller'),
            "S_route" => str_slug($input->getArgument('module')),
            "S_icon" => $input->hasArgument('icon')?$input->getArgument('icon'):"fa fa-arrow-right"
        ];

        $vendor_directory =sprintf("%s/%s",ROOT,$input->getArgument('vendor'));

        $module_directory =sprintf("%s/%s",$vendor_directory,$this->filteredName($input->getArgument('module')));

        $directory_controller =sprintf("%s/Route",$module_directory);
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

            $icon[$this->Default['S_controller']]=[
                'controller'=>$this->Default['S_controller'],
                'name'=>$this->Default['S_Demo'],
                'icon'=>$this->Default['S_icon'],
            ];

            $template = file_get_contents(sprintf("%s/data/template/Route", ROOT));

            if(!file_exists(sprintf("%s/data/menu.json", ROOT))):

                file_put_contents(sprintf("%s/data/menu.json", ROOT),json_encode($icon));

            else:

                $menu = file_get_contents(sprintf("%s/data/menu.json", ROOT));

                file_put_contents(sprintf("%s/data/menu.json", ROOT),json_encode(array_merge(json_decode($menu),$icon)));

            endif;



            $template = str_replace($this->aFind, $this->aSub, $template);


            file_put_contents(sprintf("%s/%sRoute.php", $directory_controller, $this->filteredName($input->getArgument('controller'))), $template);

            $error =$template;
        }

        $output->write($error);
    }
}
