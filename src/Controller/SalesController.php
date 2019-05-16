<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Entity\Sale;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;


class SalesController extends AbstractController
{

    /**
     * @Route("/sales/new", name="sales_new"))
     */
    public function insert()
    {
        $sale = new Sale();
        $message = NULL;
        $form = $this->createFormBuilder($sale)
        ->add('Product', ChoiceType::class, [
                'choices' => $this->getDoctrine()
                ->getRepository(Product::class)
                ->getChoice()
                ]
        )
        //getChoice() - finAll()
        ->add('Amount', NumberType::class)
        ->add('save', SubmitType::class, ['label' => 'Make Sale'])
        ->getForm();

        $request = Request::createFromGlobals();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $sale = $form->getData();
            if ($sale->getproduct()!=-1){
                $entityManager = $this->getDoctrine()->getManager();
                //if (is_numeric($sale->getProduct())){//TODO...
                //    $sale->setProduct($this->getDoctrine()
                //    ->getRepository(Product::class)
                //    ->getOneChoice($sale->getProduct())[0]['productname']);
                //}
                $entityManager->persist($sale);
                $entityManager->flush();
                $message = '<div class="alert alert-success">New Sales Created</div>';
            } else {
                $message = '<div class="alert alert-danger">Select the Product.</div>';
            }
        }
        return $this->render('sales/new.html.twig', [
            'message' => $message, 'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/sales/show", name="sales_show")
     */
    public function show()
    {
        $sale = new Sale();
        $message = NULL;
        $res = NULL;
        $form = $this->createFormBuilder($sale)
        ->add('Product', ChoiceType::class, [
                'choices' => $this->getDoctrine()
                ->getRepository(Product::class)
                ->getChoice(FALSE)
                ]
        )
        ->add('check', SubmitType::class, ['label' => 'Search'])
        ->getForm();

        //$result = 1;
        $request = Request::createFromGlobals();
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $sale = $form->getData();
            if ($sale->getproduct()!=-1){
                $res = $this->getDoctrine()
                        ->getRepository(Sale::class)
                        ->findBy(array('product' => $sale->getProduct()));

                //findBy(array('name' => 'Registration'),array('name' => 'ASC'),1 ,0)[0]
                echo $sale->getProduct();
            }  else {
                $res = $this->getDoctrine()
                        ->getRepository(Sale::class)
                        ->findAll();
            }
            if (!$res) {
                $message = 'No sales found for '.$sale->getProduct();
            }
        }

        return $this->render('sales/show.html.twig', [
            'res' => $res, 'message' => $message, 'form' => $form->createView()
        ]);
    
    }

    /**
     * @Route("/product/{idproducto}", name="product_show")
     */
    public function product_show($idproducto)
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($idproducto);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return new Response('Check out this great product: '.$product->getProductname());

        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
    }
}