<?php


namespace Exfriend\Recipe;


use Illuminate\Console\Command as LaravelCommand;

class MakeRecipe extends LaravelCommand
{

    protected $signature = 'recipe:make {recipe?} {--schema=} {--save-to=} {--overwrite} {--echo}';

    public function choiceOrEnterManually( $question, $choices, $enterManuallyQuestion, $default )
    {
        $choices = collect( $choices )->push( 'Select this or skip to enter manually' );

        $value = $this->choice( $question, $choices->toArray(), $choices->keys()->last() );
        if ( $value == 'Select this or skip to enter manually' )
        {
            $value = $this->anticipate( $enterManuallyQuestion, [ $default ] );
        }
        return $value;
    }

    public function handle()
    {

        if ( !$recipe = $this->argument( 'recipe' ) )
        {
            $availableRecipes = collect( require( base_path( 'recipes/config.php' ) ) )->keys()->toArray();
            $recipe = $this->choice( 'You did not provide a recipe. Please choose one', $availableRecipes );
        }
        $recipe = recipe( $recipe );

        if ( $jsonPath = $this->option( 'schema' ) )
        {
            $recipe->withSchema( $jsonPath );
        }

        $recipe->interact( $this );
        $compiled = $recipe->build();

        $this->saveToFile( $recipe, $compiled );

        if ( $this->option( 'echo' ) )
        {
            echo $compiled;
        }


        $this->info( 'Recipe built!' );
    }

    /**
     * @param $recipe
     * @param $compiled
     */
    protected function saveToFile( $recipe, $compiled ): void
    {
        $saveTo = $this->option( 'save-to' );

        if ( !$saveTo )
        {
            if ( !in_array( 'file', $recipe->saveTo ) )
            {
                return;
            }

            if ( !$this->confirm( 'Save to file?', true ) )
            {
                return;
            }
        }

        $saveTo = $this->askWithCompletion( 'Please enter relative file path', [ $recipe->getDefaultFilePath() ], $recipe->getDefaultFilePath() );

        if ( file_exists( $saveTo ) && !$this->option( 'overwrite' ) )
        {
            if ( $this->confirm( 'File exists. Do you wish to overwrite it?', true ) )
            {
                file_put_contents( $saveTo, $compiled );
            }
            else
            {
                $this->warn( 'Nothing to do, exiting' );
            }
        }
        file_put_contents( $saveTo, $compiled );
    }

}