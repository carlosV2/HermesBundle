<?php

namespace Carlosv2\HermesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SendInterfaceController extends Controller
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        $content = $this->get('templating')->render('HermesBundle::index.html.twig', $this->loadAssetFiles());

        return new Response($content, 200, ['Content-Type' => 'text/html']);
    }

    /**
     * @return array
     */
    private function loadAssetFiles()
    {
        return [
            'css' => $this->loadFolderContents(__DIR__ . '/../Resources/public/css/'),
            'js' => $this->loadFolderContents(__DIR__ . '/../Resources/public/js/'),
        ];
    }

    /**
     * @param string $folderPath
     *
     * @return array
     */
    private function loadFolderContents($folderPath)
    {
        $files = [];

        if ($dh = opendir($folderPath)) {
            while (($file = readdir($dh)) !== false) {
                if (!is_dir($file)) {
                    $files[$file] = file_get_contents($folderPath . $file);
                }
            }
            closedir($dh);
        }

        return $files;
    }
}
