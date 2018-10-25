<?php

namespace Flexe\Commands;

use Flexe\Db\Init;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class SiteGenerator extends Command
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
            ->setName('site')
            ->setDescription('Cria um site com base no pacote data/Site')
            ->setHelp('Altere o template para refletir a alteração')
            ->addArgument('vendor', InputArgument::REQUIRED, 'vendor name')
            ->addArgument('app', InputArgument::REQUIRED, 'O namespace da class')
            ->addArgument('module', InputArgument::REQUIRED, 'O module name')
            ->addArgument('controller', InputArgument::REQUIRED, 'O controller name da classe')
            ->addArgument('name', InputArgument::REQUIRED, 'O site name da classe')
            ->addArgument('page');
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
            "S_navigation" => '',
        ];


        $pages = [];

        $pages[] = 'about';
        if($input->hasArgument('page')):

            $pages = array_merge($pages ,array_filter(explode(",",$input->getArgument('page'))));

        endif;

        $functions =[];
        $routes =[];
        $S_menu =[];

        if($pages):

            foreach ($pages as $page):
                $html= [];
                $html[] =sprintf(' $this->get("/%s", "%s\%s\Controller\%sController:%s")->setName("%s.%s");',
                    $page,
                    $this->Default["S_App"],
                    $this->Default["S_Parent"],
                    $this->Default["S_Demo"],
                    $page,
                    $this->Default["S_controller"],$page);
                $routes[] = implode(PHP_EOL, $html);
                $html= [];

                $html[] =sprintf(' <a href="<?=$this->url("%s.%s")?>" class="navbar-brand d-flex align-items-center"><strong>%s</strong></a>',
                    $this->Default["S_route"],$page,$page);
                $S_menu[] = implode(PHP_EOL, $html);

                $html= [];
                $html[] =sprintf(' public function %s(Request $request, Response $response, $args = []){', $page);
                $html[] =sprintf('$this->Render->setTemplate("%s/%s");',$this->Default["S_route"], $page);
                $html[] =PHP_EOL;
                $html[] ='                  return $this->Render->render();';
                $html[] =PHP_EOL;
                $html[] ='                 }';
                $functions[] = implode(PHP_EOL, $html);
                $this->create_page($page);


            endforeach;

        endif;

        $this->Default["S_navigation"] = implode(PHP_EOL, $routes);

        $this->Default["S_menu"] = implode(PHP_EOL, $S_menu);

        $this->Default["S_actions"] = implode(PHP_EOL, $functions);

        $this->newName = $this->filteredName($input->getArgument('controller'));

        $this->data['controller'] = $input->getArgument('controller');

        $output->write($this->copiar_diretorio($input->getArgument('module')));

        $this->create_page_layout();
    }

    private function copiar_diretorio($destine, $directory = "data/Site", $ver_acao = true)
    {

        $this->aFind = array_keys($this->Default);

        $this->aSub = array_values($this->Default);

        $Cried[] = "Site Gerado Com Sucesso";

        if ($destine{strlen($destine) - 1} == '/') {

            $destine = substr($destine, 0, -1);

        }

        // $destine = sprintf("%s/%s/%s",dirname(__DIR__, 3),$this->Default['S_Vendor'], $destine);
        $dir = sprintf("%s/%s/%s",dirname(__DIR__, 3),$this->Default['S_Vendor'], $destine);

        if (!is_dir($dir)) {

            if ($ver_acao) {

                $Cried[] = "Criando diretorio {$destine}\n";
            }

            mkdir($dir, 0755);
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
                            || array_search("Model",$case)
                            || array_search("Table",$case)
                            || array_search("Route",$case)
                            || array_search("Form",$case)
                            || array_search("Filter",$case)
                            || array_search("Middleware",$case)
                            || array_search("config",$case)):
                            $name = sprintf("%s.php",$name);
                        elseif (array_search("views",$case)):
                            $name = sprintf("%s.phtml",$name);
                        endif;

                        $this->copyemz($this->getDirectory($directory, $item),$this->Default['S_Vendor'], $name);

                    endif;

                endif;
            }
        }



        return implode(PHP_EOL, $Cried);
    }

    private function create_page($file){

        $this->aFind = array_keys($this->Default);

        $this->aSub = array_values($this->Default);

        $fileDemo = sprintf("%s/data/template/site/%s", ROOT,$file);

        if(file_exists($fileDemo)):

            $template = file_get_contents($fileDemo);

        else:

            $template = file_get_contents(sprintf("%s/data/template/site/index", ROOT));

        endif;

        $template = str_replace($this->aFind, $this->aSub, $template);

        $dir = sprintf("%s/%s", dirname(__DIR__, 3), $this->Default['S_Vendor']);

        if(!is_dir(sprintf("%s/%s",$dir,$this->Default['S_Parent']))):

            mkdir(sprintf("%s/%s",$dir,$this->Default['S_Parent']));

        endif;

        if(!is_dir(sprintf("%s/%s/views",$dir,$this->Default['S_Parent']))):

            mkdir(sprintf("%s/%s/views",$dir,$this->Default['S_Parent']));

        endif;

        if(!is_dir(sprintf("%s/%s/views/%s",$dir,$this->Default['S_Parent'],$this->Default['S_route']))):

            mkdir(sprintf("%s/%s/views/%s",$dir,$this->Default['S_Parent'],$this->Default['S_route']));

        endif;

        $template = str_replace($this->aFind, $this->aSub, $template);

        $directory = sprintf("%s/%s/views/%s",$dir,
            $this->Default['S_Parent'],
            $this->Default['S_route']);

        file_put_contents(sprintf("%s/%s.phtml", $directory, $file), $template);

        $error =$template;


    }

    private function create_page_layout(){


        $this->aFind = array_keys($this->Default);

        $this->aSub = array_values($this->Default);


        $dir = sprintf("%s/%s", dirname(__DIR__, 3), $this->Default['S_Vendor']);

        $directory = sprintf("%s/views/layout/%s",$dir,
            $this->Default['S_route']);

        $template = file_get_contents(sprintf("%s/data/template/site/template", ROOT));

        $template = str_replace($this->aFind, $this->aSub, $template);

        file_put_contents(sprintf("%s.phtml", $directory), $template);

        $error =$template;


    }

}
