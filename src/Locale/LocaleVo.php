<?php

namespace hollisho\htranslator\Locale;

class LocaleVo
{
    const AR_TN = 'ar_TN'; //Arabic (Tunisia)
    const CA_ES = 'ca_ES'; //Catalan
    const ZH_CN = 'zh_CN'; //Chinese
    const ZH_TW = 'zh_TW'; //Chinese (traditional)
    const CS_CZ = 'cs_CZ'; //Czech
    const DA_DK = 'da_DK'; //Danish
    CONST NL_NL = 'NL_NL'; //Dutch
    const EN_CA = 'en_CA'; //English (Canada)
    const EN_GB = 'en_GB'; //English (British)
    const EN_US = 'en_US'; //English (American)
    const EO_EO = 'eo_EO'; //Esperanto
    CONST FA_IR = 'fa_IR'; //Farsi
    const FI_FI = 'fi_FI'; //Finnish
    const FR_FR = 'fr_FR'; //French (Europe)
    const FR_CA = 'fr_CA'; //French (Canada)
    const DE_DE = 'de_DE'; //German (Germany)
    const HU_HU = 'hu_HU'; //Hungarian
    const ID_ID = 'id_ID'; //Indonesian
    const IT_IT = 'it_IT'; //Italian
    const JA_JP = 'ja_JP'; //Japanese
    const KZ_KZ = 'kz_KZ'; //Kazakh
    const OC_LNC = 'oc_LNC'; //Lengadocian
    const LV_LV = 'lv_LV'; //Latvian (Latviešu)
    const PL_PL = 'pl_PL'; //Polish
    const PT_BR = 'pt_BR'; //Portuguese (Brazil)
    const PT_PT = 'pt_PT'; //Portuguese (Portugal)
    const RU_RU = 'ru_RU'; //Russian (Basic version)
    const ES_ES = 'es_ES'; //Spanish (Europe)
    const SV_SE = 'sv_SE'; //Swedish
    const UK_UA = 'uk_UA'; //Ukrainian
    const TH_TH = 'th_TH'; //Thai
    const TR_TR = 'tr_TR'; //Turkish
    const VI_VN = 'vi_VN'; //Vietnamese

    public static function values(): array
    {
        return [
            self::AR_TN,
            self::CA_ES,
            self::ZH_CN,
            self::ZH_TW,
            self::CS_CZ,
            self::DA_DK,
            self::NL_NL,
            self::EN_CA,
            self::EN_GB,
            self::EN_US,
            self::EO_EO,
            self::FA_IR,
            self::FI_FI,
            self::FR_FR,
            self::FR_CA,
            self::DE_DE,
            self::HU_HU,
            self::ID_ID,
            self::IT_IT,
            self::JA_JP,
            self::KZ_KZ,
            self::OC_LNC,
            self::LV_LV,
            self::PL_PL,
            self::PT_BR,
            self::PT_PT,
            self::RU_RU,
            self::ES_ES,
            self::SV_SE,
            self::UK_UA,
            self::TH_TH,
            self::TR_TR,
            self::VI_VN,
        ];
    }

    public static function getItems()
    {
        $items = [];
        foreach (self::values() as $value) {
            $items[strtoupper($value)] = $value;
        }
        return $items;
    }

    public static function assertValidLocale($locale)
    {
        return in_array($locale, self::values());
    }



}