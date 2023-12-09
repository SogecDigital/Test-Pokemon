<?php

namespace App\Command;

use App\Entity\Pokemon;
use App\Entity\Type;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:import-pokemons',
    description: 'Imports pokemons from a CSV',
)]
class ImportPokemonsCommand extends Command
{
    private EntityManagerInterface $entityManager;

    /** @var array<string, Type> */
    private array $types;

    /** @var array<int, Pokemon> */
    private array $pokemonIds;

    /** @var string[] */
    private array $duplicated;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('url', InputArgument::REQUIRED, 'URL of the CSV file to import')
            ->addUsage('app:import-pokemons https://github.com/SogecDigital/Test-Pokemon/raw/nino/pokemon.csv')
        ;

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->confirm($input, $output)) {
            return Command::SUCCESS;
        }

        $io = new SymfonyStyle($input, $output);
        /** @var string $url */
        $url = $input->getArgument('url');

        $handle = fopen($url, 'rb');
        if (false === $handle) {
            $io->error("Couldn't open the given url.");

            return Command::FAILURE;
        }

        $fields = fgetcsv($handle);
        if (false === $fields) {
            $io->error('Empty file');

            return Command::FAILURE;
        }

        $this->resetPokemons();
        $fields = $this->formatFields($fields);

        $row = $added = 0;
        while (($data = fgetcsv($handle)) !== false) {
            ++$row;
            $lineData = array_combine($fields, $data);
            if (false === $lineData) {
                $io->warning("Error on row $row, skipping.");
                continue;
            }

            if (isset($this->pokemonIds[$lineData['id']])) {
                $this->duplicated[] = $row;
                continue;
            }

            $types = $this->addTypeToCollection($lineData['type_1'] ?? null);
            $types = $this->addTypeToCollection($lineData['type_2'] ?? null, $types);

            unset($lineData['type_1'], $lineData['type_2']);

            $pokemon = new Pokemon(...$lineData);
            $pokemon->types = $types;
            $this->entityManager->persist($pokemon);

            $this->pokemonIds[$pokemon->id] = true;
            ++$added;
        }
        fclose($handle);
        $this->entityManager->flush();

        if ($this->duplicated !== []) {
            $io->warning(["Multiple entries with the same pokedex # is not supported yet.", 'rows: ' . implode(', ', $this->duplicated)]);
        }

        $io->success("$added pokemons imported.");

        return Command::SUCCESS;
    }

    private function confirm(InputInterface $input, OutputInterface $output): bool
    {
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion(
            'This will overwrite the pokemons in the database, continue? [y/N] ',
            false
        );

        return $helper->ask($input, $output, $question);
    }

    private function resetPokemons(): void
    {
        $this->entityManager->createQueryBuilder()
            ->delete()
            ->from(Pokemon::class, 'p')
            ->getQuery()
            ->execute();
    }

    private function formatFields(array $fields): array
    {
        return array_map(
            static fn ($field) => '#' === $field ? 'id' : mb_strtolower(str_replace(['. ', ' '], '_', $field)),
            $fields
        );
    }

    private function addTypeToCollection(?string $name, ArrayCollection $collection = new ArrayCollection()): ArrayCollection
    {
        if (empty($name)) {
            return $collection;
        }

        $this->types[$name] = $this->types[$name]
            ?? $this->entityManager->getRepository(Type::class)->findOneByNameOrNew($name);
        $collection->add($this->types[$name]);

        return $collection;
    }
}
