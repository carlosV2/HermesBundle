<?php

namespace Carlosv2\HermesBundle\Controller;

use Carlosv2\HermesBundle\Dto\EmailDto;
use Carlosv2\HermesBundle\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class MessagesApiController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function getAction()
    {
        $messages = array_map(function (\Swift_Mime_Message $message) {
            return EmailDto::fromSwiftMimeMessage($message);
        }, $this->getRepository()->loadAll());

        return new JsonResponse($messages, 200);
    }

    /**
     * @return MessageRepository
     */
    private function getRepository()
    {
        return $this->get('carlosv2.hermesbundle.message.reposiory');
    }
}
