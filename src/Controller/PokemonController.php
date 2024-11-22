<?php 

namespace App\Controller;

use App\Entity\Debilidad;
use App\Entity\Pokemon;
use App\Form\PokemonType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PokemonController extends AbstractController{
    #[Route('/pokemon/{id}', name: 'showPokemon')] 
    public function getPokemon(EntityManagerInterface $doctrine, $id){
        $repository = $doctrine -> getRepository(Pokemon::class);
        $pokemon = $repository -> find($id);
        

        return $this->render('pokemons/pokemon.html.twig', ['pokemon' => $pokemon]);
    }

    #[Route('/pokemons', name:'listPokemons')]
    public function pokemons (EntityManagerInterface $doctrine) {
       $repository = $doctrine -> getRepository(Pokemon::class);
        $pokemons = $repository -> findAll();


        return $this->render('pokemons/pokemonsList.html.twig', ['pokemons' => $pokemons]);
    }
    #[Route('/new/pokemons')]
    public function newPokemons (EntityManagerInterface $doctrine) {
    
        $pokemon = new Pokemon();
        $pokemon -> setNombre('pikachu');
        $pokemon -> setDescription('Es un pokemon amarillo que lanza rayos');
        $pokemon -> setImage('https://www.pokemon.com/static-assets/content-assets/cms2/img/pokedex/full/025.png');
        $pokemon -> setCode(838);

        $pokemon2 = new Pokemon();
        $pokemon2 -> setNombre('Frosmoth');
        $pokemon2 -> setDescription('Es un pokemon amarillo que lanza rayos');
        $pokemon2 -> setImage('https://www.pokemon.com/static-assets/content-assets/cms2/img/pokedex/full/873.png');
        $pokemon2 -> setCode(838);

        $pokemon3 = new Pokemon();
        $pokemon3 -> setNombre('Charmander');
        $pokemon3 -> setDescription('Es un pokemon amarillo que lanza rayos');
        $pokemon3 -> setImage('https://www.pokemon.com/static-assets/content-assets/cms2/img/pokedex/full/004.png');
        $pokemon3 -> setCode(838);


        $debilidad = new Debilidad();
        $debilidad -> setName('fuego');


        $debilidad2 = new Debilidad();
        $debilidad2 -> setName('agua');


        $debilidad3 = new Debilidad();
        $debilidad3 -> setName('aire');
        $pokemon -> addDebilidade($debilidad);
        $pokemon -> addDebilidade($debilidad2);
        $pokemon2 -> addDebilidade($debilidad);
        $pokemon3 -> addDebilidade($debilidad3);

        $doctrine -> persist($pokemon);
        $doctrine -> persist($pokemon2);
        $doctrine -> persist($pokemon3);
        $doctrine -> persist($debilidad);
        $doctrine -> persist($debilidad2);
        $doctrine -> persist($debilidad3);
        $doctrine -> flush();

        return new Response('Pokemons insertados correctamente');
    }

    #[Route('/insert/pokemon', name:'InsertPokemon')]
    public function InsertPokemons (EntityManagerInterface $doctrine, Request $request){
        
        $form = $this -> createForm(PokemonType::class);
        $form -> handleRequest($request);
        
        if($form-> isSubmitted() && $form -> isValid()){
            $pokemon = $form -> getData();
            $doctrine -> persist($pokemon);
            $doctrine -> flush();

            $this->addFlash('exito', 'Pokemon insertado correctamente');

            //$form = $this -> createForm(PokemonType::class);

            return $this->redirectToRoute('listPokemons');

        }
        return $this->render('pokemons/newPokemon.html.twig', [ 'pokemonForm' => $form ]);
    } 

    #[Route('/edit/pokemon/{id}', name:'EditPokemon')]
    public function EditPokemons (EntityManagerInterface $doctrine, Request $request, $id){
        
        $repository = $doctrine -> getRepository(Pokemon::class);
        $pokemon = $repository -> find($id);

        $form = $this -> createForm(PokemonType::class, $pokemon);
        $form -> handleRequest($request);
        
        if($form-> isSubmitted() && $form -> isValid()){
            $pokemon = $form -> getData();
            $doctrine -> persist($pokemon);
            $doctrine -> flush();

            $this->addFlash('exito', 'Pokemon editado correctamente');

            //$form = $this -> createForm(PokemonType::class);

            return $this->redirectToRoute('listPokemons');

        }
        return $this->render('pokemons/newPokemon.html.twig', [ 'pokemonForm' => $form ]);
    }

    #[Route('/delete/pokemon/{id}', name:'deletePokemon')]
    public function DeletePokemons (EntityManagerInterface $doctrine, Request $request, $id){
        
        $repository = $doctrine -> getRepository(Pokemon::class);
        $pokemon = $repository -> find($id);

        $doctrine -> remove($pokemon);
        $doctrine -> flush();
        
        return $this->redirectToRoute('listPokemons');
    }

};
