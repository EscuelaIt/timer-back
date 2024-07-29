<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BoardGamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $boardGames = [
            ['name' => 'Catan', 'year' => 1995, 'country_id' => 1],
            ['name' => 'Risk', 'year' => 1957, 'country_id' => 2],
            ['name' => 'Monopoly', 'year' => 1935, 'country_id' => 3],
            ['name' => 'Carcassonne', 'year' => 2000, 'country_id' => 1],
            ['name' => 'Ticket to Ride', 'year' => 2004, 'country_id' => 1],
            ['name' => 'Pandemic', 'year' => 2008, 'country_id' => 1],
            ['name' => '7 Wonders', 'year' => 2010, 'country_id' => 2],
            ['name' => 'Dominion', 'year' => 2008, 'country_id' => 3],
            ['name' => 'Azul', 'year' => 2017, 'country_id' => 2],
            ['name' => 'Terraforming Mars', 'year' => 2016, 'country_id' => 1],
            ['name' => 'Codenames', 'year' => 2015, 'country_id' => 2],
            ['name' => 'Agricola', 'year' => 2007, 'country_id' => 1],
            ['name' => 'Scythe', 'year' => 2016, 'country_id' => 1],
            ['name' => 'Splendor', 'year' => 2014, 'country_id' => 1],
            ['name' => 'Puerto Rico', 'year' => 2002, 'country_id' => 1],
            ['name' => 'Gloomhaven', 'year' => 2017, 'country_id' => 1],
            ['name' => 'The Settlers of Catan', 'year' => 1995, 'country_id' => 1],
            ['name' => 'Twilight Struggle', 'year' => 2005, 'country_id' => 1],
            ['name' => 'Power Grid', 'year' => 2004, 'country_id' => 1],
            ['name' => 'Stone Age', 'year' => 2008, 'country_id' => 1],
            ['name' => 'Small World', 'year' => 2009, 'country_id' => 1],
            ['name' => 'Wingspan', 'year' => 2019, 'country_id' => 1],
            ['name' => 'The Castles of Burgundy', 'year' => 2011, 'country_id' => 1],
            ['name' => '7 Wonders Duel', 'year' => 2015, 'country_id' => 2],
            ['name' => 'Patchwork', 'year' => 2014, 'country_id' => 1],
            ['name' => 'Everdell', 'year' => 2018, 'country_id' => 1],
            ['name' => 'Kingdomino', 'year' => 2016, 'country_id' => 1],
            ['name' => 'Clank!', 'year' => 2016, 'country_id' => 1],
            ['name' => 'Concordia', 'year' => 2013, 'country_id' => 1],
            ['name' => 'Orléans', 'year' => 2014, 'country_id' => 1],
            ['name' => 'Viticulture', 'year' => 2013, 'country_id' => 1],
            ['name' => 'Great Western Trail', 'year' => 2016, 'country_id' => 1],
            ['name' => 'Spirit Island', 'year' => 2017, 'country_id' => 1],
            ['name' => 'Lost Ruins of Arnak', 'year' => 2020, 'country_id' => 2],
            ['name' => 'The Quacks of Quedlinburg', 'year' => 2018, 'country_id' => 2],
            ['name' => 'On Mars', 'year' => 2020, 'country_id' => 2],
            ['name' => 'Tzolk\'in: The Mayan Calendar', 'year' => 2012, 'country_id' => 2],
            ['name' => 'Brass: Birmingham', 'year' => 2018, 'country_id' => 1],
            ['name' => 'Root', 'year' => 2018, 'country_id' => 1],
            ['name' => 'Blood Rage', 'year' => 2015, 'country_id' => 1],
            ['name' => 'Clans of Caledonia', 'year' => 2017, 'country_id' => 2],
            ['name' => 'Teotihuacan: City of Gods', 'year' => 2018, 'country_id' => 2],
            ['name' => 'Gaia Project', 'year' => 2017, 'country_id' => 2],
            ['name' => 'Lisboa', 'year' => 2017, 'country_id' => 2],
            ['name' => 'Rising Sun', 'year' => 2018, 'country_id' => 1],
            ['name' => 'Azul: Stained Glass of Sintra', 'year' => 2018, 'country_id' => 2],
            ['name' => 'Pax Pamir (Second Edition)', 'year' => 2019, 'country_id' => 1],
            ['name' => 'The Gallerist', 'year' => 2015, 'country_id' => 2],
            ['name' => 'Arkham Horror: The Card Game', 'year' => 2016, 'country_id' => 1],
            ['name' => 'Underwater Cities', 'year' => 2018, 'country_id' => 2],
            ['name' => 'Robinson Crusoe: Adventures on the Cursed Island', 'year' => 2012, 'country_id' => 2],
            ['name' => 'The Crew: The Quest for Planet Nine', 'year' => 2019, 'country_id' => 2],
            ['name' => 'Eclipse', 'year' => 2011, 'country_id' => 1],
            ['name' => 'Alhambra', 'year' => 2003, 'country_id' => 2],
            ['name' => 'Star Wars: Imperial Assault', 'year' => 2014, 'country_id' => 1],
            ['name' => 'Betrayal at House on the Hill', 'year' => 2004, 'country_id' => 1],
            ['name' => 'Dead of Winter: A Crossroads Game', 'year' => 2014, 'country_id' => 1],
            ['name' => 'Eldritch Horror', 'year' => 2013, 'country_id' => 1],
            ['name' => 'Mysterium', 'year' => 2015, 'country_id' => 2],
            ['name' => 'Zombicide', 'year' => 2012, 'country_id' => 1],
            ['name' => 'Descent: Journeys in the Dark (Second Edition)', 'year' => 2012, 'country_id' => 1],
            ['name' => 'King of Tokyo', 'year' => 2011, 'country_id' => 2],
            ['name' => 'Sheriff of Nottingham', 'year' => 2014, 'country_id' => 1],
            ['name' => 'Camel Up', 'year' => 2014, 'country_id' => 2],
            ['name' => 'T.I.M.E Stories', 'year' => 2015, 'country_id' => 2],
            ['name' => 'Terraforming Mars: Ares Expedition', 'year' => 2021, 'country_id' => 1],
            ['name' => 'Tapestry', 'year' => 2019, 'country_id' => 1],
            ['name' => 'A Feast for Odin', 'year' => 2016, 'country_id' => 1],
            ['name' => 'The Resistance: Avalon', 'year' => 2012, 'country_id' => 1],
            ['name' => 'Kemet', 'year' => 2012, 'country_id' => 2],
            ['name' => 'Anachrony', 'year' => 2017, 'country_id' => 2],
            ['name' => 'Raiders of the North Sea', 'year' => 2015, 'country_id' => 1],
            ['name' => 'Santorini', 'year' => 2016, 'country_id' => 1],
            ['name' => 'Decrypto', 'year' => 2018, 'country_id' => 2],
            ['name' => 'Hanabi', 'year' => 2010, 'country_id' => 2],
            ['name' => 'Cosmic Encounter', 'year' => 1977, 'country_id' => 1],
            ['name' => 'The Mind', 'year' => 2018, 'country_id' => 2],
            ['name' => 'Detective: A Modern Crime Board Game', 'year' => 2018, 'country_id' => 2],
            ['name' => 'Arkham Horror (Third Edition)', 'year' => 2018, 'country_id' => 1],
            ['name' => 'Nemesis', 'year' => 2018, 'country_id' => 2],
            ['name' => 'Gloomhaven: Jaws of the Lion', 'year' => 2020, 'country_id' => 1],
            ['name' => 'Chronicles of Crime', 'year' => 2018, 'country_id' => 2],
            ['name' => 'The Voyages of Marco Polo', 'year' => 2015, 'country_id' => 2],
            ['name' => 'Five Tribes', 'year' => 2014, 'country_id' => 2],
            ['name' => 'Tokaido', 'year' => 2012, 'country_id' => 2],
            ['name' => 'Mechs vs. Minions', 'year' => 2016, 'country_id' => 1],
            ['name' => 'Mage Knight Board Game', 'year' => 2011, 'country_id' => 2],
            ['name' => 'Through the Ages: A New Story of Civilization', 'year' => 2015, 'country_id' => 2],
            ['name' => 'Terraforming Mars: Turmoil', 'year' => 2019, 'country_id' => 1],
            ['name' => 'Lords of Waterdeep', 'year' => 2012, 'country_id' => 1],
            ['name' => 'Clank! Legacy: Acquisitions Incorporated', 'year' => 2019, 'country_id' => 1],
            ['name' => 'Inis', 'year' => 2016, 'country_id' => 2],
            ['name' => 'Maracaibo', 'year' => 2019, 'country_id' => 2],
            ['name' => 'Orléans: Invasion', 'year' => 2015, 'country_id' => 1],
            ['name' => 'Dune', 'year' => 1979, 'country_id' => 1],
            ['name' => 'Frosthaven', 'year' => 2022, 'country_id' => 1],
            ['name' => 'Barrage', 'year' => 2019, 'country_id' => 2],
            ['name' => 'Caylus', 'year' => 2005, 'country_id' => 2],
            ['name' => 'Clue', 'year' => 1949, 'country_id' => 3],
            ['name' => 'Jenga', 'year' => 1983, 'country_id' => 3],
            ['name' => 'Scrabble', 'year' => 1938, 'country_id' => 3],
            ['name' => 'Chess', 'year' => null, 'country_id' => 3],
            ['name' => 'Checkers', 'year' => null, 'country_id' => 3],
            ['name' => 'Go', 'year' => null, 'country_id' => 3],
            ['name' => 'Backgammon', 'year' => null, 'country_id' => 3],
            ['name' => 'Pictionary', 'year' => 1985, 'country_id' => 3],
            ['name' => 'Trivial Pursuit', 'year' => 1981, 'country_id' => 3],
            ['name' => 'Yahtzee', 'year' => 1956, 'country_id' => 3],
            ['name' => 'Uno', 'year' => 1971, 'country_id' => 3],
            ['name' => 'Battleship', 'year' => 1967, 'country_id' => 3],
            ['name' => 'Parcheesi', 'year' => 1867, 'country_id' => 3],
            ['name' => 'Candy Land', 'year' => 1949, 'country_id' => 3],
            ['name' => 'Sorry!', 'year' => 1934, 'country_id' => 3],
            ['name' => 'Trouble', 'year' => 1965, 'country_id' => 3],
            ['name' => 'The Game of Life', 'year' => 1960, 'country_id' => 3],
            ['name' => 'Mouse Trap', 'year' => 1963, 'country_id' => 3],
            ['name' => 'Risk: Legacy', 'year' => 2011, 'country_id' => 2],
            ['name' => 'Risk: Star Wars Edition', 'year' => 2015, 'country_id' => 1],
        ];
        

        foreach ($boardGames as $game) {
            DB::table('board_games')->insert([
                'slug' => Str::slug($game['name']),
                'name' => $game['name'],
                'year' => $game['year'],
                'country_id' => $game['country_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}