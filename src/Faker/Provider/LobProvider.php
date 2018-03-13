<?php

namespace App\Faker\Provider;

use Faker\Provider\Base as BaseProvider;

final class LobProvider extends BaseProvider
{
    /**
     * Sources: {@link http://siliconvalleyjobtitlegenerator.tumblr.com/}
     *
     * @var array List of job titles.
     */
    const TITLE_PROVIDER = [
        'firstname' => [
            'Audience Recognition',
            'Big Data',
            'Bitcoin',
            '...',
            'Video Experience',
            'Wearables',
            'Webinar',
        ],
        'lastname' => [
            'Advocate',
            'Amplifier',
            'Architect',
            '...',
            'Warlock',
            'Watchman',
            'Wizard',
        ],
        'fullname' => [
            'Conductor of Datafication',
            'Crowd-Funder-in-Residence',
            'Quantified-Self-in-Residence',
            '...',
            'Tech-Svengali-in-Residence',
            'Tech-Wizard-in-Residence',
            'Thought-Leader-in-Residence',
        ],
    ];

    /**
     * Sources: {@link http://sos.uhrs.indiana.edu/Job_Code_Title_Abbreviation_List.htm}
     *
     * @var array List of job abbreviations.
     */
    const ABBREVIATION_PROVIDER = [
        'ABATE',
        'ACAD',
        'ACCT',
        '...',
        'WCTR',
        'WSTRN',
        'WKR',
    ];

    /**
     * @return string Random job title.
     */
    public function lobTitle()
    {
        $names = [
            sprintf(
                '%s %s',
                self::randomElement(self::TITLE_PROVIDER['firstname']),
                self::randomElement(self::TITLE_PROVIDER['lastname'])
            ),
            self::randomElement(self::TITLE_PROVIDER['fullname']),
        ];

        return self::randomElement($names);
    }

    /**
     * @return string Random job abbreviation title
     */
    public function lobAbbreviation()
    {
        return self::randomElement(self::ABBREVIATION_PROVIDER);
    }


}