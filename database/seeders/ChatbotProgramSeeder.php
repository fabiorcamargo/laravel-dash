<?php

namespace Database\Seeders;

use App\Models\ChatbotProgram;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatbotProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ChatbotProgram::insert([
            [
                "tipo" => "militar",
                "i_fluxo" => null,
                "f_fluxo" => "1.1",
                "message" => "Sim,sim,SIM",
                "response" => "🇧🇷 *Ótimo, futuro soldado!* 🇧🇷\n            ↪️ Fico muito feliz, mas me fala uma coisa! O que mais te chamou a atenção na carreira militar? 🪖\n             \n            1️⃣ Salários e benefícios;\n            2️⃣ Treinamento e educação;\n            3️⃣ Oportunidades de viagem;\n            4️⃣ Sentido de propósito;\n            5️⃣ Benefícios pós-carreira;\n            6️⃣ Oportunidade de carreira.\n            \n            ‼️ Digite *apenas* o número.",
            ],
            [
                "tipo" => "militar",
                "i_fluxo" => null,
                "f_fluxo" => "1.2.f",
                "message" => "Não,não,NÂO",
                "response" => "😕 Entendi! \n            ▶️ Conte-nos o motivo que fez você perder o interesse.",
            ],
            [
                "tipo" => "militar",
                "i_fluxo" => "1.1.1",
                "f_fluxo" => "1.1.f",
                "message" => "1",
                "response" => "✅ É verdade! Isso chama muita atenção.\r \r             🇧🇷 Um militar de carreira tem uma remuneração inicial de *4 a 10 mil reais por mês, aposentadorias, seguros de saúde e outros benefícios.*\r             ▫️ Exige _dedicação_ e _compromisso_, podendo ser uma escolha *recompensadora* para aqueles dispostos a servir!\r             \r             🪖 Existem *outros* fatores atrativos que eu vou te apresentar daqui a 3️⃣ dias. \r             \r             📳 Aguarde a mensagem confirmando o *Local*, *Endereço* e *Horário.*\r",
            ],
            [
                "tipo" => "militar",
                "i_fluxo" => "1.1.2",
                "f_fluxo" => "1.1.f",
                "message" => "2",
                "response" => "✅ É verdade! Isso chama muita atenção.\r \r             🇧🇷 A carreira militar no Brasil oferece *inúmeras* oportunidades de _treinamento e capacitação educacional_ para seus militares, ajudando-os a *crescer profissionalmente* e a *desempenhar suas funções de forma eficiente.*\r             📚 A educação é *incentivada* e *apoiada* pelo Exército Brasileiro, que oferece programas de _bolsas de estudo_ para militares que desejam continuar seus estudos e obter diploma de *graduação ou pós-graduação.*\r             \r             🪖 Existem *outros* fatores atrativos que eu vou te apresentar daqui a 3️⃣ dias. \r             \r             📳 Aguarde a mensagem confirmando o *Local*, *Endereço* e *Horário.*",	
            ],
            [
                "tipo" => "militar",
                "i_fluxo" => "1.1.3",
                "f_fluxo" => "1.1.f",
                "message" => "3",
                "response" => "✅ É verdade! Isso chama muita atenção.\r \r             🇧🇷 Os militares no Brasil têm a oportunidade de *viajar a serviço* para diferentes locais. Essas viagens podem ser realizadas para *cumprir missões, participar de treinamentos ou para representar o Exército em eventos oficiais.* \r             🌐 Além disso, os militares também têm a oportunidade de *viajar* para participar de _programas de intercâmbio_ com outros países, o que lhes permite *ampliar* seus horizontes e *adquirir* novas habilidades e conhecimentos.\r             \r             🪖 Existem *outros* fatores atrativos que eu vou te apresentar daqui a 3️⃣ dias. \r             \r             📳 Aguarde a mensagem confirmando o *Local*, *Endereço* e *Horário.*",	
            ],
            [
                "tipo" => "militar",
                "i_fluxo" => "1.1.4",
                "f_fluxo" => "1.1.f",
                "message" => "4",
                "response" => "✅ É verdade! Isso chama muita atenção.\r \r             🇧🇷 A carreira militar no Brasil oferece aos indivíduos uma oportunidade única de servir a uma causa maior, desenvolver o sentido de propósito e patriotismo, e fazer parte de uma comunidade de servidores dedicados e comprometidos.\r             🎖️ Os militares servem como defensores da pátria, trabalhando dia após dia para garantir a segurança e a proteção da nação.\r             \r             🪖 Existem outros fatores atrativos que eu vou te apresentar daqui a 3️⃣ dias. \r             \r             📳 Aguarde a mensagem confirmando o Local, Endereço e Horário.",	
            ],
            [
                "tipo" => "militar",
                "i_fluxo" => "1.1.5",
                "f_fluxo" => "1.1.f",
                "message" => "5",
                "response" => "✅ É verdade! Isso chama muita atenção.\r \r             🇧🇷 A pós-carreira dos militares do Brasil envolve uma série de benefícios, incluindo=> Aposentadoria com o salário integral, assistência médica gratuita em hospitais militares, auxílio funerário, auxílio moradia e descontos em vários serviços!\r             \r             🪖 Existem outros fatores atrativos que eu vou te apresentar daqui a 3️⃣ dias. \r             \r             📳 Aguarde a mensagem confirmando o Local, Endereço e Horário.\r",	
            ],
            [
                "tipo" => "militar",
                "i_fluxo" => "1.1.6",
                "f_fluxo" => "1.1.f",
                "message" => "6",
                "response" => "✅ É verdade! Isso chama muita atenção.\r \r             🇧🇷 Existem diversas oportunidades de carreira para um militar no Brasil, com diversos programas de especialização e treinamento.\r             🎖️ Além de poderem seguir carreira nas áreas de combate, navegação e aviação, os militares podem atuar em áreas de _logística, inteligência, saúde e administração em cada uma das Forças Armadas ( Exército, Marinha e Força Aérea )._\r             \r             🪖 Existem outros fatores atrativos que eu vou te apresentar daqui a 3️⃣ dias. \r             \r             📳 Aguarde a mensagem confirmando o Local, Endereço e Horário.",	
            ],
            [
                "tipo" => "militar",
                "i_fluxo" => "1.2.f",
                "f_fluxo" => "1.1.f",
                "message" => "*",
                "response" => "✅ Não se preocupe, nós compreendemos! \r \r 💬 Caso mude de ideia, daqui a 3️⃣ dias estarei em sua cidade apresentando *todos* os fatores atrativos dessa carreira! \r \r 📳 Aguarde a mensagem confirmando o *Local, Endereço e Horário.*\r",	
            ],
            [
                "tipo" => "militar",
                "i_fluxo" => "1.1.f",
                "f_fluxo" => "1.1.f",
                "message" => "*",
                "response" => "‼️ Opa! Vi que você tem mais dúvidas, mas no momento não vou estar conseguindo responder! \n✅ *Faz assim=>*\n▶️ Deixe tudo anotadinho e no dia do atendimento, pessoalmente, irei tirá-las com você! 😉",
            ],
            [
                "tipo" => "militar",
                "i_fluxo" => "Ocupado",
                "f_fluxo" => null,
                "message" => "*",
                "response" => "‼️ Olá! Te peço desculpas, mas no momento não vou conseguir responder!",
            ],
            [
                "tipo" => "militar",
                "i_fluxo" => null,
                "f_fluxo" => null,
                "message" => "Cadastro realizado com sucesso",
                "response" => "✅ *Parabéns!!!*\n‼️ Em breve você receberá novas informações. \n📲 Para isso, salve o nosso contato.",	
            ],
            [
                "tipo" => "militar",
                "i_fluxo" => "erro",
                "f_fluxo" => null,
                "message" => "*",
                "response" => "‼ Para eu conseguir dar continuidade, preciso que você me mande apenas o número da opção desejada.",
            ]
        ]   
        );
    }
}

