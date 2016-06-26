<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Prospect;
use AppBundle\Repository\ProspectRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMInvalidArgumentException;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class ProspectController
 * @package AppBundle\Controller
 *
 * @Route("/prospects", service="app.controller.prospect")
 */
class ProspectController
{
    /**
     * @var ProspectRepository
     */
    private $prospectRepository;

    /**
     * ProspectController constructor.
     * @param ProspectRepository $prospectRepository
     */
    public function __construct(ProspectRepository $prospectRepository)
    {
        $this->prospectRepository = $prospectRepository;
    }

    /**
     * @param Prospect $prospect
     * @param ConstraintViolationListInterface $validationErrors
     * @ParamConverter(
     *     "prospect",
     *     converter = "fos_rest.request_body",
     *     class = "AppBundle\Entity\Prospect",
     * )
     *
     * @Post
     *
     * @View(
     *     statusCode = 201,
     * )
     *
     * @throws BadRequestHttpException
     * @throws OptimisticLockException
     * @throws ORMInvalidArgumentException
     */
    public function createAction(Prospect $prospect, ConstraintViolationListInterface $validationErrors)
    {
        if($validationErrors->count() > 0) {
            throw new BadRequestHttpException;
        }

        $this->prospectRepository
            ->persist($prospect)
            ->flush();
    }
}
