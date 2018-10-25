<?php

namespace Flexe\Commands;

use Flexe\Commands\TraitCommands;
use Flexe\Db\Init;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class MakeGenerator extends Command
{

   use TraitCommands;
    /**
     * @var Init|null
     */
    private $init;

    /**
     * MakeGenerator constructor.
     * @param Init|null $init
     */
    public function __construct(Init $init = null)
   {
       parent::__construct();
       $this->init = $init;
   }

    protected function configure()
    {
        $this
            ->setName('make')
            ->setDescription('Cria uma app com base no pacote data/Demo')
            ->setHelp('Altere o template para refletir a alteração')
            ->addArgument('vendor', InputArgument::REQUIRED, 'vendor name')
            ->addArgument('app', InputArgument::REQUIRED, 'O namespace da class')
            ->addArgument('module', InputArgument::REQUIRED, 'O module name')
            ->addArgument('controller', InputArgument::REQUIRED, 'O controller name da classe')
            ->addArgument('name', InputArgument::REQUIRED, 'O app name da classe')
            ->addArgument('table')
            ->addArgument('icom');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $this->Default = [
            "S_Vendor" => $input->getArgument('vendor'),
            "S_Name" => $this->filteredName($input->getArgument('name')),
            "S_App" => $this->filteredName($input->getArgument('app')),
            "S_Parent" => $this->filteredName($input->getArgument('module')),
            "S_Demo" => $this->filteredName($input->getArgument('controller')),
            "S_route" => str_slug($input->getArgument('module')),
            "S_controller" => $input->getArgument('controller'),
            "S_table" => !is_null($input->getArgument('table'))?$input->getArgument('table'):str_slug($input->getArgument('controller')),
            "S_icon" => $input->hasArgument('icon')?$input->getArgument('icon'):"fa fa-arrow-right"
        ];
        if($this->init):
            $query = $this->init->from(sprintf("%ss", $this->Default['S_table']));

            $this->Default['S_fillable'] = $this->getToNativeNames($query->execute());

        endif;

        $this->newName = $this->filteredName($input->getArgument('controller'));

        $this->data['controller'] = $input->getArgument('controller');

        $icon[$this->Default['S_controller']]=[
            'controller'=>sprintf("%s.%s",$this->Default['S_route'],$this->Default['S_controller']),
            'name'=>$this->Default['S_Name'],
            'icon'=>$this->Default['S_icon'],
        ];


        if(!file_exists(sprintf("%s/data/menu.json", ROOT))):

            file_put_contents(sprintf("%s/data/menu.json", ROOT),json_encode($icon));

        else:

            $menu = file_get_contents(sprintf("%s/data/menu.json", ROOT));

            $actual = json_decode($menu,true);

            $update = array_merge($actual, $icon);

            file_put_contents(sprintf("%s/data/menu.json", ROOT),json_encode($update));

        endif;

        $output->write($this->copiar_diretorio($input->getArgument('module')));
    }

    private function copiar_diretorio($destine, $directory = "data/Demo", $ver_acao = true)
    {
        $this->aFind = array_keys($this->Default);

        $this->aSub = array_values($this->Default);

        $Cried[] = "Modulo Gerado Com Sucesso";

        if ((strlen($destine) - 1) == '/') {

            $destine = substr($destine, 0, -1);

        }

        // $destine = sprintf("%s/%s/%s",dirname(__DIR__, 3),$this->Default['S_Vendor'], $destine);
        $dir = sprintf("%s/%s/%s",dirname(__DIR__, 3),$this->Default['S_Vendor'], $destine);

        if (!is_dir(str_replace("_","-",$dir))) {

            if ($ver_acao) {

                $Cried[] = "Criando diretorio {$destine}\n";
            }

            mkdir(str_replace("_","-",$dir), 0755);
        }

        $folder = opendir($directory);

        while ($item = readdir($folder)) {

            if ($item == '.' || $item == '..') {

                continue;

            }

            if (is_dir($this->getDirectory($directory, $item))) {

                $Cried[] = "Copiando {$item} para {$destine}/{$item}" . "\n";

                $this->copiar_diretorio($this->getDestine($destine, $item), $this->getDirectory($directory, $item), $ver_acao);

            } else {
                if (!empty($this->newName)):

                    if (!file_exists($this->getDestine($destine, $item))):

                        if ($ver_acao) {

                            $Cried[] = "Copiando {$item} para {$destine}/{$item}" . "\n";

                        }

                        $name = $this->getDestine($destine, $item);
                        $case = explode("/", $name);
                        if(array_search("Controller",$case)
                            || array_search("Form",$case)
                            || array_search("Model",$case)
                            || array_search("Filter",$case)
                            || array_search("Table",$case)
                            || array_search("Route",$case)
                            || array_search("config",$case)):
                            $name = sprintf("%s.php",$name);
                        elseif (array_search("views",$case)):
                            $name = str_replace("_","-",sprintf("%s.phtml",$name));
                        endif;

                        $this->copyemz($this->getDirectory($directory, $item),$this->Default['S_Vendor'], $name);

                    endif;

                endif;
            }
        }

        return implode(PHP_EOL, $Cried);
    }

}
