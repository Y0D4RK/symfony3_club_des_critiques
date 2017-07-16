<?php

namespace AppBundle\Service;

use AppBundle\Entity\Rank;

/**
 * Service Voter
 *
 */
class Voter{

    private $formerVote;
    private $voter;
    private $category;
    private $artwork;

    public function __construct($formerVote, $voter, $artwork, $category){
        $this->formerVote = $formerVote;
        $this->voter = $voter;
        $this->artwork = $artwork;
        $this->category = $category;
    }

    public function note($table, $record_id, $user_id, $note){
        $vote = $this->vote($table, $record_id, $user_id, $note);
        $this->updateVote($table, $record_id, true);
        return $vote;
    }
//    /**
//     * Créer les dossier necessaire à l'op
//     *
//     */
//    public function makeDirDomain(Game $game){
//
//        $newDir = $game->getShortDomainName();
//
//        if(!file_exists($this->newGamePath.$newDir)) {
//
//            $folders = ['', '/www', '/www/css', '/www/img'];
//
//            foreach($folders as $folder){
//                $newDirectoryPath = $this->newGamePath.$newDir.$folder;
//                $fileObject = new File($newDirectoryPath);
//                $fileObject->mkdirs();
//            }
//
//            return true;
//        }else{
//            $deletePath = $this->newGamePath.$newDir;
//            $dirObject = new File($deletePath);
//            $dirObject->deleteAll();
//
//            var_dump("Le dossier est deja présent, mais est supprimé.. F5 pour relancer l'action de création !");
//            exit;
//        }
//    }
//
//    public function moveImg(Game $game)
//    {
//        $newDir = $game->getShortDomainName();
//
//        $sourcePath = $this->templatePath.'/tmp/';
//        $targetPath = $this->newGamePath.$newDir.'/www/img';
//
//        $listObject = new File($sourcePath);
//
//        $iteratorObject = $listObject->listFiles();
//
//        foreach ($iteratorObject as $subFileObject) {
//            $image = new File($sourcePath.$subFileObject->getBasename());
//
//            if(strpos($image->getFilename(), $newDir) !== false){
//                $image->copy($targetPath);
//            }
//        }
//
//        return true;
//    }
//
//    public function copyTemplate(Game $game)
//    {
//        $newDir = $game->getShortDomainName();
//
//        #COPY HTML
//        $htmlSourcePath = $this->templatePath.'/'.$game->getTemplate().'/template_'.$game->getTemplate().'.html';
//        $htmlTargetPath = $this->newGamePath.$newDir.'/www';
//
//        $htmlObject = new File($htmlSourcePath);
//        $htmlObject->copy($htmlTargetPath);
//
//        $htmlObject->rename('index.html');
//
//        #COPY CSS
//        $cssSourcePath = $this->templatePath.'/'.$game->getTemplate().'/css/screen-ope.css';
//        $cssTargetPath = $this->newGamePath.$newDir.'/www/css';
//
//        $cssObject = new File($cssSourcePath);
//        $cssObject->copy($cssTargetPath);
//
//        return true;
//    }
//
//    public function editTemplate(Game $game)
//    {
//        $newDir = $game->getShortDomainName();
//
//        $game->setDeployed(1);
//
//        $htmlPath = $this->newGamePath.$newDir.'/www/index.html';
//        $cssPath = $this->newGamePath.$newDir.'/www/css/screen-ope.css';
//
//        $htmlString = file_get_contents($htmlPath);
//        $cssString = file_get_contents($cssPath);
//
//        $params = $game->getParamsToDeploy();
//        $css = $game->getCssToDeploy();
//
//        $css_keys = array_keys($css);
//        $css_values = array_values($css);
//
//        $params_keys = array_keys($params);
//        $params_values = array_values($params);
//
//        $templateHtml = str_replace($params_keys, $params_values, $htmlString);
//        $templateCss = str_replace($css_keys, $css_values, $cssString);
//
//        $newFileHtml = new FileWriter($htmlPath, 'w+');
//        $newFileCss = new FileWriter($cssPath, 'w+');
//
//        $newFileHtml->write($templateHtml);
//        $newFileCss->write($templateCss);
//
//
//        var_dump($params);
//        var_dump($params_keys);
//        var_dump($params_values);
//        var_dump($templateHtml);
//
//        var_dump($css);
//        var_dump($css_keys);
//        var_dump($css_values);
//        var_dump($templateCss);
//
//        exit();
//
//        return true;
//
//    }

}

