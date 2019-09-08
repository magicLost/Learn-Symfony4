<?php

namespace App\Security;


//use App\Form\Security\LoginFormType;
//use App\Service\WorkWithTargetPath;
use App\Entity\Auth\User;
use App\Service\WorkWithTargetPath;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;


class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    use TargetPathTrait;

    private $formFactory;
    private $entityManager;
    private $router;
    private $passwordEncoder;
    private $workWithTargetPath;
    private $csrfTokenManager;

    public function __construct(
        FormFactoryInterface $formFactory,
        EntityManagerInterface $entityManager,
        RouterInterface $router,
        UserPasswordEncoderInterface $passwordEncoder,
        WorkWithTargetPath $workWithTargetPath,
        CsrfTokenManagerInterface $csrfTokenManager
    )
    {
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->router = $router;
        $this->passwordEncoder = $passwordEncoder;
        $this->workWithTargetPath = $workWithTargetPath;
        $this->csrfTokenManager = $csrfTokenManager;
    }

    public function supports(Request $request)
    {

        return $request->getPathInfo() == '/login_check' && $request->isMethod('post');
    }
    /*
     * Evals every request
     * */
    public function getCredentials(Request $request)
    {

        //dump($_POST);
        dump($request->request);

        $username = $request->request->get("_username");
        $password = $request->request->get("_password");
        $token = $request->request->get("_csrf_token");

        if (false === $this->csrfTokenManager->isTokenValid(new CsrfToken('authenticate', $token))) {
            throw new InvalidCsrfTokenException('Invalid CSRF token.');
        }

        $request->getSession()->set(
            Security::LAST_USERNAME,
            $username
        );

        return [
            '_password' => $password,
            '_username' => $username
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        //credentials is our data from getCredentials()
        $userName = $credentials['_username'];

        if (null === $userName) {
            return null;
        }

        //dump($this->entityManager->getRepository(User::class)->findAll());

        // if a User object, checkCredentials() is called
        return $userProvider->loadUserByUsername($userName);

    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        //credentials is our data from getCredentials()
        //user is object that returns by getUser()
        $password = $credentials['_password'];


        if($this->passwordEncoder->isPasswordValid($user, $password)){
            return true;
        }

        return false;
    }

    protected function getLoginUrl()
    {
        return $this->router->generate("fos_user_security_login");
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {

        $url = $this->workWithTargetPath->getRedirectUri($request);

        //$this->removeTargetPath($request->getSession(), $providerKey);

        return new RedirectResponse($url);

    }

}