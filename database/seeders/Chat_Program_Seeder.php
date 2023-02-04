<?php

namespace Database\Seeders;

use App\Models\ChatProgram;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Chat_Program_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ChatProgram::insert([
            [
            'i_fluxo' => 'Início',
            'f_fluxo' => 'Menu',
            'message' => 'Sim, Não',
            'response' => '🇧🇷 *Ótimo, futuro soldado!* 🇧🇷
            ↪️ Fico muito feliz, mas me fala uma coisa! O que mais te chamou a atenção na carreira militar? 🪖
             
            1️⃣ Salários e benefícios;
            2️⃣ Treinamento e educação;
            3️⃣ Oportunidades de viagem;
            4️⃣ Sentido de propósito;
            5️⃣ Benefícios pós-carreira;
            6️⃣ Oportunidade de carreira.
            
            ‼️ Digite *apenas* o número.',
            ],
            [
            'i_fluxo' => 'Menu',
            'f_fluxo' => 'Escolha',
            'message' => '1,2,3,4,5,6',
            'response' => '🇧🇷 *Ótimo, futuro soldado!* 🇧🇷
            ↪️ Fico muito feliz, mas me fala uma coisa! O que mais te chamou a atenção na carreira militar? 🪖
             
            1️⃣ Salários e benefícios;
            2️⃣ Treinamento e educação;
            3️⃣ Oportunidades de viagem;
            4️⃣ Sentido de propósito;
            5️⃣ Benefícios pós-carreira;
            6️⃣ Oportunidade de carreira.
            
            ‼️ Digite *apenas* o número.',
            ],
            [
            'i_fluxo' => '1',
            'f_fluxo' => 'Fim',
            'message' => 'Início',
            'response' => '✅ É verdade! Isso chama muita atenção.

            🇧🇷 Um militar de carreira tem uma remuneração inicial de *4 a 10 mil reais por mês, aposentadorias, seguros de saúde e outros benefícios.*
            ▫️ Exige _dedicação_ e _compromisso_, podendo ser uma escolha *recompensadora* para aqueles dispostos a servir!
            
            🪖 Existem *outros* fatores atrativos que eu vou te apresentar daqui a 3️⃣ dias. 
            
            📳 Aguarde a mensagem confirmando o *Local*, *Endereço* e *Horário.*
            
            Atenciosamente, _divulgador_.',
            ],
            [
            'i_fluxo' => 'Menu',
            'f_fluxo' => 'Escolha',
            'message' => '1,2,3,4,5,6',
            'response' => '🇧🇷 *Ótimo, futuro soldado!* 🇧🇷
            ↪️ Fico muito feliz, mas me fala uma coisa! O que mais te chamou a atenção na carreira militar? 🪖
             
            1️⃣ Salários e benefícios;
            2️⃣ Treinamento e educação;
            3️⃣ Oportunidades de viagem;
            4️⃣ Sentido de propósito;
            5️⃣ Benefícios pós-carreira;
            6️⃣ Oportunidade de carreira.
            
            ‼️ Digite *apenas* o número.',
            ],
            [
            'i_fluxo' => '1',
            'f_fluxo' => 'Fim',
            'message' => 'Início',
            'response' => '✅ É verdade! Isso chama muita atenção.

            🇧🇷 Um militar de carreira tem uma remuneração inicial de *4 a 10 mil reais por mês, aposentadorias, seguros de saúde e outros benefícios.*
            ▫️ Exige _dedicação_ e _compromisso_, podendo ser uma escolha *recompensadora* para aqueles dispostos a servir!
            
            🪖 Existem *outros* fatores atrativos que eu vou te apresentar daqui a 3️⃣ dias. 
            
            📳 Aguarde a mensagem confirmando o *Local*, *Endereço* e *Horário.*
            
            Atenciosamente, _divulgador_.',
            ],
            [
            'i_fluxo' => '2',
            'f_fluxo' => 'Fim',
            'message' => 'Início',
            'response' => '✅ É verdade! Isso chama muita atenção.

            🇧🇷 A carreira militar no Brasil oferece *inúmeras* oportunidades de _treinamento e capacitação educacional_ para seus militares, ajudando-os a *crescer profissionalmente* e a *desempenhar suas funções de forma eficiente.*
            📚 A educação é *incentivada* e *apoiada* pelo Exército Brasileiro, que oferece programas de _bolsas de estudo_ para militares que desejam continuar seus estudos e obter diploma de *graduação ou pós-graduação.*
            
            🪖 Existem *outros* fatores atrativos que eu vou te apresentar daqui a 3️⃣ dias. 
            
            📳 Aguarde a mensagem confirmando o *Local*, *Endereço* e *Horário.*
            
            Atenciosamente, _divulgador_.',
            ],
            [
            'i_fluxo' => '3',
            'f_fluxo' => 'Fim',
            'message' => 'Início',
            'response' => '✅ É verdade! Isso chama muita atenção.

            🇧🇷 Os militares no Brasil têm a oportunidade de *viajar a serviço* para diferentes locais. Essas viagens podem ser realizadas para *cumprir missões, participar de treinamentos ou para representar o Exército em eventos oficiais.* 
            🌐 Além disso, os militares também têm a oportunidade de *viajar* para participar de _programas de intercâmbio_ com outros países, o que lhes permite *ampliar* seus horizontes e *adquirir* novas habilidades e conhecimentos.
            
            🪖 Existem *outros* fatores atrativos que eu vou te apresentar daqui a 3️⃣ dias. 
            
            📳 Aguarde a mensagem confirmando o *Local*, *Endereço* e *Horário.*
            
            Atenciosamente, _divulgador_.',
            ],
            [
            'i_fluxo' => '4',
            'f_fluxo' => 'Fim',
            'message' => 'Início',
            'response' => '✅ É verdade! Isso chama muita atenção.

            🇧🇷 A carreira militar no Brasil oferece aos indivíduos uma oportunidade única de servir a uma causa maior, desenvolver o sentido de propósito e patriotismo, e fazer parte de uma comunidade de servidores dedicados e comprometidos.
            🎖️ Os militares servem como defensores da pátria, trabalhando dia após dia para garantir a segurança e a proteção da nação.
            
            🪖 Existem outros fatores atrativos que eu vou te apresentar daqui a 3️⃣ dias. 
            
            📳 Aguarde a mensagem confirmando o Local, Endereço e Horário.
            
            Atenciosamente, divulgador.',
            ],
            [
            'i_fluxo' => '5',
            'f_fluxo' => 'Fim',
            'message' => 'Início',
            'response' => '✅ É verdade! Isso chama muita atenção.

            🇧🇷 A pós-carreira dos militares do Brasil envolve uma série de benefícios, incluindo: Aposentadoria com o salário integral, assistência médica gratuita em hospitais militares, auxílio funerário, auxílio moradia e descontos em vários serviços!
            
            🪖 Existem outros fatores atrativos que eu vou te apresentar daqui a 3️⃣ dias. 
            
            📳 Aguarde a mensagem confirmando o Local, Endereço e Horário.
            
            Atenciosamente, divulgador.',
            ],
            [
            'i_fluxo' => '6',
            'f_fluxo' => 'Fim',
            'message' => 'Início',
            'response' => '✅ É verdade! Isso chama muita atenção.

            🇧🇷 Existem diversas oportunidades de carreira para um militar no Brasil, com diversos programas de especialização e treinamento.
            🎖️ Além de poderem seguir carreira nas áreas de combate, navegação e aviação, os militares podem atuar em áreas de _logística, inteligência, saúde e administração em cada uma das Forças Armadas ( Exército, Marinha e Força Aérea )._
            
            🪖 Existem outros fatores atrativos que eu vou te apresentar daqui a 3️⃣ dias. 
            
            📳 Aguarde a mensagem confirmando o Local, Endereço e Horário.
            
            Atenciosamente, divulgador.',
            ],
            [
            'i_fluxo' => 'Não',
            'f_fluxo' => 'Fim',
            'message' => 'Início',
            'response' => '😕 Entendi! 
            ▶️ Conte-nos o motivo que fez você perder o interesse.',
            ]

        ]
        );
    }
}
