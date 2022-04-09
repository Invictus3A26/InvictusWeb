<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserType;
use App\Form\PasswordProfileType;
use App\Form\ProfileType;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use phpDocumentor\Reflection\Types\Nullable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Twilio\Rest\Client;


class UserController extends AbstractController
{
    private $twilio;
    private $fromNumber;

    public function __construct(Client $twilio,EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
        $this->twilio = $twilio;
        $this->fromNumber = "+17853776886";

    }

    /**
     * @Route("/ResetPasswordEmail/mobile" , name="api_mdpoubliee" )
     */
    public function mobile_mdpoubliee(EntityManagerInterface $entityManager, Request $request,UserRepository $userRepository){

        $user = $userRepository->findOneBy(['email' => $request->get('username')]);
        if ( $user ){
            $bytes = random_bytes(3);
            $verificationCode = bin2hex($bytes);
            $user->SetVerificationCode($verificationCode);
            $this->twilio->messages->create("+216". $user->getPhoneNumber(), [
                'from' => $this->fromNumber,
                'body' => "To Activate Your account please use this code upon logging in \n Code :$verificationCode"
            ]);
            $entityManager->persist($user);
            $entityManager->flush();
            return new JsonResponse([
                'success' => "password reset has been activated"
            ]);
        }else{
            return new JsonResponse([
                'error' => "invalid email"
            ]);
        }
    }

    /**
     * @Route("/ResetPasswordCode/mobile", name="api_PhoneNumberCodeResetPassword", methods={"POST"})
     */
    public function api_PhoneNumberCodeResetPassword(UserRepository $userRepository,NormalizerInterface $normalizable, EntityManagerInterface $entityManager,Request $request)
    {
        $code = $request->get('code');
        $email = $request->get('useremail');
        $user = $userRepository->findOneBy(['email' => $email , 'verificationCode' => $code ]);
        if ($user){
            $userData = new User();
            $user->setVerificationCode(null);
            $entityManager->persist($user);
            $entityManager->flush();
            return new JsonResponse([
                'success' => "code successful"
            ]);
        }else{
            return new JsonResponse([
                'error' => "please insert a valid code for your reset password request"
            ]);
        }


    }

    /**
     * @Route("/resetPasswordUser/mobile", name="api_resetPasswordUser", methods={"POST"})
     */
    public function api_resetPasswordUser(UserRepository $userRepository, UserPasswordEncoderInterface $userPasswordEncoder, NormalizerInterface $normalizable, EntityManagerInterface $entityManager,Request $request,UserPasswordEncoderInterface $passwordHasher )
    {
        $user = $userRepository->findOneBy(['email' => $request->get('useremail')]);

        if ( $user ){
            $password = $request->get('password');
            $Confirmpassword = $request->get('confirmpassword');

            if ( $password ==  $Confirmpassword){
                $user->setPassword(
                    $userPasswordEncoder->encodePassword(
                        $user,
                        $request->get('password')
                    )
                );
                $entityManager->persist($user);
                $entityManager->flush();
                return new JsonResponse([
                    'success' => "Password updated"
                ]);
            }else{
                return new JsonResponse([
                    'error' => "Password doesnt match"
                ]);
            }

        }else{
            return new JsonResponse([
                'error' => "user doesnt exist"
            ]);
        }

    }



    /**
     * @Route("/editUser/mobile", name="api_editUser", methods={"POST"})
     */
    public function api_EditUser(UserRepository $userRepository,NormalizerInterface $normalizable, EntityManagerInterface $entityManager,Request $request)
    {
        $user = new User();
        $user = $userRepository->findOneBy(['id' => $request->get('id')]);
        if ( $user ){
            $user->setFirstname($request->get('firstname'));
            $user->setLastname($request->get('lastname'));
            $user->setusertag($request->get('username'));
            $user->setEmail($request->get('email'));
            $user->setPhoneNumber($request->get('phonenumber'));
            $user->setRoles(["ROLE_".$request->get('roles')]);
            $entityManager->persist($user);
            $entityManager->flush();
            return new JsonResponse([
                'success' => "user has been updated"
            ]);
        }else{
            return new JsonResponse([
                'error' => "error updating , please try again"
            ]);
        }
    }

    /**
     * @Route("/editProfile/mobile", name="api_editProfile", methods={"POST"})
     */
    public function api_EditProfile(UserRepository $userRepository,NormalizerInterface $normalizable, EntityManagerInterface $entityManager,Request $request)
    {
        $user = new User();
        $user = $userRepository->findOneBy(['id' => $request->get('id')]);
        if ( $user ){
            $user->setFirstname($request->get('firstname'));
            $user->setLastname($request->get('lastname'));
            $user->setusertag($request->get('username'));
            $user->setEmail($request->get('email'));
            $user->setPhoneNumber($request->get('phonenumber'));
            $user->setRoles(["ROLE_".$request->get('roles')]);
            $entityManager->persist($user);
            $entityManager->flush();
            return new JsonResponse([
                'success' => "user has been updated"
            ]);
        }else{
            return new JsonResponse([
                'error' => "error updating , please try again"
            ]);
        }
    }

    /**
     * @Route("/PhoneNumberCode/mobile", name="api_PhoneNumberCode", methods={"POST"})
     */
    public function api_PhoneNumberCode(UserRepository $userRepository,NormalizerInterface $normalizable, EntityManagerInterface $entityManager,Request $request)
    {
        $code = $request->get('code');
        $idUser = $request->get('UserId');
        $user = $userRepository->findOneBy(['id' => $idUser , 'verificationCode' => $code ]);
        if ($user){
            $userData = new User();
            $user->setVerificationCode(null);
            $entityManager->persist($user);
            $entityManager->flush();
            return new JsonResponse([
                'success' => "account has been activated"
            ]);
        }else{
            return new JsonResponse([
                'error' => "please insert a valid code for your account"
            ]);
        }
    }

    /**
     * @Route("/UpdatePassword/mobile", name="api_UpdatePasswordMobile")
     */
    public function UpdatePassword_Mobile(UserRepository $userRepository,NormalizerInterface $normalizable, EntityManagerInterface $entityManager,Request $request,UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $password = $request->get('password');
        $email = $request->get('UserEmail');
        $user = $userRepository->findOneBy(['email' => $email]);

        if ( $user){
            $user->setPassword(
                $userPasswordEncoder->encodePassword(
                    $user,
                    $password
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();
            return new JsonResponse([
                'success' => "password has been updated"
            ]);

        }else{
            return new JsonResponse([
                'error' => "error updating user"
            ]);
        }

    }

    /**
     * @Route("/signup/mobile", name="api_signup", methods={"POST"})
     */
    public function api_signup( UserPasswordEncoderInterface $userPasswordEncoder, NormalizerInterface $normalizable, EntityManagerInterface $entityManager,Request $request,UserPasswordEncoderInterface $passwordHasher )
    {
        //$users = $userRepository->findAll();
        $user = new User();
        $user->setFirstname($request->get('firstname'));
        $user->setLastname($request->get('lastname'));
        $user->setusertag($request->get('username'));
        $user->setEmail($request->get('email'));
        $user->setPhoneNumber($request->get('phonenumber'));


        $user->setPassword(
            $userPasswordEncoder->encodePassword(
                $user,
                $request->get('password')
            )
        );
        $current_date = new \DateTime('@'.strtotime('+01:00'));
        $user->setLastLoginDate($current_date);
        $user->setRoles(["ROLE_".$request->get('roles')]);

        $bytes = random_bytes(3);
        $verificationCode = bin2hex($bytes);
        $user->SetVerificationCode($verificationCode);

        $this->twilio->messages->create("+216". $user->getPhoneNumber(), [
            'from' => $this->fromNumber,
            'body' => "To Activate Your account please use this code upon logging in \n Code :$verificationCode"
        ]);


        $user->setIsVerified(1);
        $entityManager->persist($user);
        $entityManager->flush();
        return new JsonResponse([
            'success' => "user has been added"
        ]);
    }

    /**
     * @Route("/login/mobile", name="api_login", methods={"POST"})
     */
    public function api_login(NormalizerInterface $normalizable,UserRepository $userRepository,Request $request,UserPasswordEncoderInterface $passwordHasher )
    {
        //$users = $userRepository->findAll();

        $user = $userRepository->findOneBy(['email' => $request->get('username')]);
        if ( $user ){
            $result = $passwordHasher->isPasswordValid($user, $request->get('password'));
            if ( $result ){
                $jsonContent = $normalizable->normalize($user, 'json' , [ 'groups'=> 'read:users' ]);
                return new Response(json_encode($jsonContent));
            }
        }
        return new JsonResponse([
            'error' => "invalid informations"
        ]);

    }

    /**
     * @Route("/all/users", name="users_mobile", methods={"GET"})
     */
    public function mobile_all_users(NormalizerInterface $normalizable,UserRepository $userRepository,Request $request)
    {
        $users = $userRepository->findAll();
        $jsonContent = $normalizable->normalize($users, 'json' , [ 'groups'=> 'read:users' ]);
        return new Response(json_encode($jsonContent));
    }



    /**
     * @Route("/SortName/mobile", name="users_mobile_SortName")
     */
    public function mobile_SortName_users(NormalizerInterface $normalizable,UserRepository $userRepository,Request $request)
    {
        $users = $userRepository->SortByFirstName();
        $jsonContent = $normalizable->normalize($users, 'json' , [ 'groups'=> 'read:users' ]);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/SortEmail/mobile", name="users_mobile_SortEmail")
     */
    public function mobile_SortEmail_users(NormalizerInterface $normalizable,UserRepository $userRepository,Request $request)
    {
        $users = $userRepository->SortByEmail();
        $jsonContent = $normalizable->normalize($users, 'json' , [ 'groups'=> 'read:users' ]);
        return new Response(json_encode($jsonContent));
    }




    /**
     * @Route("/profile/delete", name="delete_profile", methods={"GET,POST"})
     */
    public function delete_profile(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/profile/editPassword", name="edit_profile_password", methods={"GET", "POST"})
     */
    public function edituserpassword(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(PasswordProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {
            $user->setPassword(
                $userPasswordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('profile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/profile_edit_password.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profile/edit", name="edit_profile", methods={"GET" , "POST" })
     */
    public function edit_profile(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('profile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/profile_edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/profile", name="profile", methods={"GET"})
     */
    public function profile(UserRepository $userRepository): Response
    {

        return $this->render('user/profile.html.twig', [
            'user' => $userRepository->findOneBy(['id' => $this->getUser()->getId()]),
        ]);
    }


    /**
     * @IsGranted("ROLE_USER")
     * @Route("/ActivateAccountWithCode", name="ActivateAccountWithCode", methods={"GET","POST"})
     */
    public function ActivateAccountWithCode(UserRepository $userRepository, Request $request,PaginatorInterface $paginator): Response
    {
        $error = null;
        if ( $request->isMethod('POST')) {
            $code = $request->request->get('verificationcode');
            $codeUser = $this->getUser()->getVerificationCode();
            if ( $code == $codeUser){
                $user = new User();
                $user = $this->getUser();
                $user->setVerificationCode(null);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                return $this->redirectToRoute("app_login");
            }
            else{
                $error = "Please Verify your Code";
                return $this->render('security/ActivateAccountWithCode.html.twig',[
                    'error' => $error,
                ]);
            }
        }
        return $this->render('security/ActivateAccountWithCode.html.twig',[
            'error' => $error,
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/user/", name="user_index", methods={"GET", "POST"})
     */
    public function index(UserRepository $userRepository, Request $request,PaginatorInterface $paginator): Response
    {
        $back = null;
        if ( $request->isMethod('POST')) {

            if ( $request->request->get('optionsRadios')){
                $SortKey = $request->request->get('optionsRadios');
                switch ($SortKey){
                    case 'email':
                        $users = $userRepository->SortByEmail();
                        break;

                    case 'firstname':
                        $users = $userRepository->SortByFirstName();
                        break;

                    case 'usertag':
                        $users = $userRepository->SortByUserTag();
                        break;

                    case 'phonenumber':
                        $users = $userRepository->SortByPhoneNumber();
                        break;
                }
            }
            else
            {
                $type = $request->request->get('optionsearch');
                $value = $request->request->get('Search');
                switch ($type){
                    case 'email':
                        $users = $userRepository->findByEmail($value);
                        break;

                    case 'firstname':
                        $users = $userRepository->findByFirstName($value);
                        break;

                    case 'lastname':
                        $users = $userRepository->findByLastName($value);
                        break;

                    case 'usertag':
                        $users = $userRepository->findByUserTag($value);
                        break;

                    case 'phonenumber':
                        $users = $userRepository->findByPhoneNumber($value);
                        break;
                }
            }


            if ( $users){
                $back = "success";
            }else{
                $back = "failure";
            }

            $usersPaginator = $paginator->paginate(
                $users, // Requête contenant les données à paginer (ici nos articles)
                $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
                5 // Nombre de résultats par page
            );

            return $this->render('user/index.html.twig', [
                'users' => $usersPaginator,
                'back' => $back,
            ]);
        }

        $users = $userRepository->findAll();
        $usersPaginator = $paginator->paginate(
            $users, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            5 // Nombre de résultats par page
        );

        return $this->render('user/index.html.twig', [
            'users' => $usersPaginator,
            'back' => $back,
        ]);
    }

    /**
     * @Route("/user/new", name="user_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/user/{id}/editusernp", name="user_edit", methods={"GET", "POST"})
     */
    public function editusernp(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/delete/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }
        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }



    /**
     * @Route("/disable_user/{id}", name="disable_user", methods={"GET", "POST"})
     */
    public function disable_user(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $user->setDisableToken("1");
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);

    }

    /**
     * @Route("/enable_user/{id}", name="enable_user", methods={"GET", "POST"})
     */
    public function enable_user(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $user->setDisableToken(null);
        $entityManager->persist($user);
        $entityManager->flush();
        //$link = $request->headers->get("referer");
        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);

    }


    /**
     * @Route("/DisabledAccount", name="DisabledAccount")
     */
    public function DisabledAccount(): Response
    {
        return $this->render('user/DisabledAccount.html.twig');
    }
}
