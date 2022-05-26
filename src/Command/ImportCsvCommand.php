<?php

namespace App\Command;

use App\Entity\Pokemon;
use App\Entity\PokemonType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PokemonTypeRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

#[AsCommand(
    name: 'app:import:csv',
    description: 'Import CSV',
)]
class ImportCsvCommand extends Command
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Path of the CSV file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');
        
        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
            $datas = $serializer->decode(file_get_contents($arg1), 'csv', [CsvEncoder::DELIMITER_KEY => ',']);
            
            if($datas)
            {
                // Import of the type of pokemon
                $types = array();
                foreach ($datas as $data)
                {
                    if(!in_array($data['Type 1'], $types) && $data['Type 1'] != NULL){
                        array_push($types, $data['Type 1']);
                    }
                }
                foreach($types as $type)
                {
                    if(!$this->entityManager->getRepository(PokemonType::class)->findOneBy(['name'=>$type])){
                        $pokemonType = new PokemonType();
                        $pokemonType->setName($type);
                        $this->entityManager->persist($pokemonType);
                    }
                }
                $this->entityManager->flush();
                
                // import the pokemons
                foreach($datas as $data)
                {
                    $type1 = $this->entityManager->getRepository(PokemonType::class)->findOneBy(['name'=>$data['Type 1']]);
                    $type2 = $this->entityManager->getRepository(PokemonType::class)->findOneBy(['name'=>$data['Type 2']]);

                    $isLegendary = $data['Legendary']=='False' ? false : true;

                    // If pokemon exist, we update him, else we create him
                    if(!$pokemon=$this->entityManager->getRepository(Pokemon::class)->findOneBy(['name'=>$data['Name']])) $pokemon = new Pokemon();

                    $pokemon->setGameId($data['#']);
                    $pokemon->setName($data['Name']);
                    $pokemon->setType1($type1);
                    if($type2) $pokemon->setType2($type2);
                    $pokemon->setTotal($data['Total']);
                    $pokemon->setHP($data['HP']);
                    $pokemon->setAttack($data['Attack']);
                    $pokemon->setDefense($data['Defense']);
                    $pokemon->setSpAtk($data['Sp'][' Atk']);
                    $pokemon->setSpDef($data['Sp'][' Def']);
                    $pokemon->setSpeed($data['Speed']);
                    $pokemon->setGeneration($data['Generation']);
                    $pokemon->setLegendary($isLegendary);

                    $this->entityManager->persist($pokemon);
                }
                $this->entityManager->flush();
            }
        }

        //$io->error('Vous n\'avez pas renseigner le chemin');
        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
