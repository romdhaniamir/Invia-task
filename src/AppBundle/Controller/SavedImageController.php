<?php

namespace AppBundle\Controller;

use AppBundle\Entity\SavedImage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Savedimage controller.
 *
 * @Route("savedimage")
 */
class SavedImageController extends Controller
{
    /**
     * Lists all savedImage entities.
     *
     * @Route("/", name="savedimage_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $images = $em->getRepository('AppBundle:Image')->findAll();



        $savedImages = $em->getRepository('AppBundle:SavedImage')->findAll();


        return $this->render('savedimage/index.html.twig', array(
            'savedImages' => $savedImages,
            'images' =>$images
        ));
    }

    /**
     * Creates a new savedImage entity.
     *
     * @Route("/new", name="savedimage_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $savedImage = new Savedimage();
        $form = $this->createForm('AppBundle\Form\SavedImageType', $savedImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $savedImage->upload();

            $em = $this->getDoctrine()->getManager();
            $em->persist($savedImage);
            $em->flush();

            return $this->redirectToRoute('savedimage_show', array('id' => $savedImage->getId()));
        }

        return $this->render('savedimage/new.html.twig', array(
            'savedImage' => $savedImage,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a savedImage entity.
     *
     * @Route("/{id}", name="savedimage_show")
     * @Method("GET")
     */
    public function showAction(SavedImage $savedImage)
    {
        $deleteForm = $this->createDeleteForm($savedImage);

        return $this->render('savedimage/show.html.twig', array(
            'savedImage' => $savedImage,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing savedImage entity.
     *
     * @Route("/{id}/edit", name="savedimage_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SavedImage $savedImage)
    {
        $deleteForm = $this->createDeleteForm($savedImage);
        $editForm = $this->createForm('AppBundle\Form\SavedImageType', $savedImage);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('savedimage_edit', array('id' => $savedImage->getId()));
        }

        return $this->render('savedimage/edit.html.twig', array(
            'savedImage' => $savedImage,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a savedImage entity.
     *
     * @Route("/{id}", name="savedimage_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SavedImage $savedImage)
    {
        $form = $this->createDeleteForm($savedImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($savedImage);
            $em->flush();
        }

        return $this->redirectToRoute('savedimage_index');
    }

    /**
     * Creates a form to delete a savedImage entity.
     *
     * @param SavedImage $savedImage The savedImage entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SavedImage $savedImage)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('savedimage_delete', array('id' => $savedImage->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
