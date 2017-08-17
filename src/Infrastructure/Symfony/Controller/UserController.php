<?php

namespace Infrastructure\Symfony\Controller;

use Application\DataTransformer\ExceptionDataTransformer;
use Application\DataTransformer\GetUserDataTransformer;
use Application\DataTransformer\LoginUserDataTransformer;
use Application\DataTransformer\SignUpUserDataTransformer;
use Application\Service\CancelUser;
use Application\Service\EditUser;
use Application\Service\GetUser;
use Application\Service\LoginUser;
use Application\Service\SignUpUser;
use CoreBundle\Infrastructure\Service\FormatConverter\JsonFormat;
use CoreBundle\Infrastructure\Service\FormatConverter\NonFormat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController
 * @package Infrastructure\Symfony\Controller
 */
class UserController extends Controller
{
    /**
     * @access public
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {
        /** @var SignUpUser $signUpUser */
        $signUpUser = $this->get('application.sign_up_user');
        $formatConverter = new NonFormat();

        try {
            $jsonFormat = new JsonFormat();
            $data = $jsonFormat->convert($request->getContent());
            $user = $signUpUser->execute($data);
            $dataTransformer = new SignUpUserDataTransformer($formatConverter, $user);
        } catch (\Exception $exception) {
            $dataTransformer = new ExceptionDataTransformer($formatConverter, $exception->getMessage());
        } finally {
            $data = $dataTransformer->transform();
            $response = new JsonResponse($data, $data['code'], array('Content-Type' => 'application/json'));

            return $response;
        }
    }

    /**
     * @access public
     * @param Request $request
     * @return JsonResponse
     */
    public function loginAction(Request $request)
    {
        /** @var LoginUser $loginUser */
        $loginUser = $this->get('application.login_user');
        $formatConverter = new NonFormat();

        try {
            $jsonFormat = new JsonFormat();
            $data = $jsonFormat->convert($request->getContent());
            $token = $loginUser->execute($data);
            $dataTransformer = new LoginUserDataTransformer($formatConverter, $token);
        } catch (\Exception $exception) {
            $dataTransformer = new ExceptionDataTransformer($formatConverter, $exception->getMessage());
        } finally {
            $data = $dataTransformer->transform();
            $response = new JsonResponse($data, $data['code'], array('Content-Type' => 'application/json'));
        }

        return $response;
    }

    /**
     * @access public
     * @param String $id
     * @return JsonResponse
     */
    public function getAction(String $id)
    {
        /** @var GetUser $getUser */
        $getUser = $this->get('application.get_user');
        $formatConverter = new NonFormat();

        try {
            $user = $getUser->execute(array('id' => $id));
            $dataTransformer = new GetUserDataTransformer($formatConverter, $user);
        } catch (\Exception $exception) {
            $dataTransformer = new ExceptionDataTransformer($formatConverter, $exception->getMessage());
        } finally {
            $data = $dataTransformer->transform();
            $response = new JsonResponse($data, $data['code'], array('Content-Type' => 'application/json'));
        }

        return $response;
    }

    /**
     * @access public
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request)
    {
        /** @var EditUser $editUser */
        $editUser = $this->get('application.edit_user');
        $formatConverter = new NonFormat();

        try {
            $jsonFormat = new JsonFormat();
            $data = $jsonFormat->convert($request->getContent());
            $user = $editUser->execute($data);
            $dataTransformer = new SignUpUserDataTransformer($formatConverter, $user);
        } catch (\Exception $exception) {
            $dataTransformer = new ExceptionDataTransformer($formatConverter, $exception->getMessage());
        } finally {
            $data = $dataTransformer->transform();
            $response = new JsonResponse($data, $data['code'], array('Content-Type' => 'application/json'));
        }

        return $response;
    }

    /**
     * @access public
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cancelAction(Request $request)
    {
        /** @var CancelUser $cancelUser */
        $cancelUser = $this->get('application.cancel_user');
        $formatConverter = new NonFormat();

        try {
            $jsonFormat = new JsonFormat();
            $data = $jsonFormat->convert($request->getContent());
            $user = $cancelUser->execute($data);
            $dataTransformer = new SignUpUserDataTransformer($formatConverter, $user);
        } catch (\Exception $exception) {
            $dataTransformer = new ExceptionDataTransformer($formatConverter, $exception->getMessage());
        } finally {
            $data = $dataTransformer->transform();
            $response = new JsonResponse($data, $data['code'], array('Content-Type' => 'application/json'));
        }

        return $response;
    }
}
