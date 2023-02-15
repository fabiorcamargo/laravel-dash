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
                "id"=> "1",
                "tipo"=> "militar",
                "a_fluxo"=> null,
                "p_fluxo"=> "1.1",
                "e_fluxo"=> "erro",
                "message"=> "Sim,sim,SIM",
                "response"=> "🇧🇷 *Ótimo, futuro soldado!* 🇧🇷\n\n↪️ Fico muito feliz, mas me fala uma coisa! O que mais te chamou a atenção na carreira militar? 🪖\n\n1️⃣ Salários e benefícios;\n2️⃣ Treinamento e educação;\n3️⃣ Oportunidades de viagem;\n4️⃣ Sentido de propósito;\n5️⃣ Benefícios pós-carreira;\n6️⃣ Oportunidade de carreira.\n            \n‼️ Digite *apenas* o número.",
                "created_at"=> null,
                "updated_at"=> null
            ],
            [
                "id"=> "2",
                "tipo"=> "militar",
                "a_fluxo"=> null,
                "p_fluxo"=> "1.2.f",
                "e_fluxo"=> "erro",
                "message"=> "Não,não,NÂO",
                "response"=> "😕 Entendi! \n▶️ Conte-nos o motivo que fez você perder o interesse.",
                "created_at"=> null,
                "updated_at"=> null
            ],
            [
                "id"=> "3",
                "tipo"=> "militar",
                "a_fluxo"=> "1.1.1",
                "p_fluxo"=> "1.1.f",
                "e_fluxo"=> "erro",
                "message"=> "1",
                "response"=> "✅ É verdade! Isso chama muita atenção.\n \n🇧🇷 Um militar de carreira tem uma remuneração inicial de *4 a 10 mil reais por mês, aposentadorias, seguros de saúde e outros benefícios.*\n▫️ Exige _dedicação_ e _compromisso_, podendo ser uma escolha *recompensadora* para aqueles dispostos a servir!\n             \n🪖 Existem *outros* fatores atrativos que eu vou te apresentar daqui a 3️⃣ dias. \n             \n📳 Aguarde a mensagem confirmando o *Local*, *Endereço* e *Horário.*\n",
                "created_at"=> null,
                "updated_at"=> null
            ],
            [
                "id"=> "4",
                "tipo"=> "militar",
                "a_fluxo"=> "1.1.2",
                "p_fluxo"=> "1.1.f",
                "e_fluxo"=> "erro",
                "message"=> "2",
                "response"=> "✅ É verdade! Isso chama muita atenção.\n \n🇧🇷 A carreira militar no Brasil oferece *inúmeras* oportunidades de _treinamento e capacitação educacional_ para seus militares, ajudando-os a *crescer profissionalmente* e a *desempenhar suas funções de forma eficiente.*\n📚 A educação é *incentivada* e *apoiada* pelo Exército Brasileiro, que oferece programas de _bolsas de estudo_ para militares que desejam continuar seus estudos e obter diploma de *graduação ou pós-graduação.*\n             \n🪖 Existem *outros* fatores atrativos que eu vou te apresentar daqui a 3️⃣ dias. \n             \n📳 Aguarde a mensagem confirmando o *Local*, *Endereço* e *Horário.*",
                "created_at"=> null,
                "updated_at"=> null
            ],
            [
                "id"=> "5",
                "tipo"=> "militar",
                "a_fluxo"=> "1.1.3",
                "p_fluxo"=> "1.1.f",
                "e_fluxo"=> "erro",
                "message"=> "3",
                "response"=> "✅ É verdade! Isso chama muita atenção.\n \n🇧🇷 Os militares no Brasil têm a oportunidade de *viajar a serviço* para diferentes locais. Essas viagens podem ser realizadas para *cumprir missões, participar de treinamentos ou para representar o Exército em eventos oficiais.* \n🌐 Além disso, os militares também têm a oportunidade de *viajar* para participar de _programas de intercâmbio_ com outros países, o que lhes permite *ampliar* seus horizontes e *adquirir* novas habilidades e conhecimentos.\n             \n🪖 Existem *outros* fatores atrativos que eu vou te apresentar daqui a 3️⃣ dias. \n             \n📳 Aguarde a mensagem confirmando o *Local*, *Endereço* e *Horário.*",
                "created_at"=> null,
                "updated_at"=> null
            ],
            [
                "id"=> "6",
                "tipo"=> "militar",
                "a_fluxo"=> "1.1.4",
                "p_fluxo"=> "1.1.f",
                "e_fluxo"=> "erro",
                "message"=> "4",
                "response"=> "✅ É verdade! Isso chama muita atenção.\n \n🇧🇷 A carreira militar no Brasil oferece aos indivíduos uma oportunidade única de servir a uma causa maior, desenvolver o sentido de propósito e patriotismo, e fazer parte de uma comunidade de servidores dedicados e comprometidos.\n🎖️ Os militares servem como defensores da pátria, trabalhando dia após dia para garantir a segurança e a proteção da nação.\n             \n🪖 Existem outros fatores atrativos que eu vou te apresentar daqui a 3️⃣ dias. \n             \n📳 Aguarde a mensagem confirmando o Local, Endereço e Horário.",
                "created_at"=> null,
                "updated_at"=> null
            ],
            [
                "id"=> "7",
                "tipo"=> "militar",
                "a_fluxo"=> "1.1.5",
                "p_fluxo"=> "1.1.f",
                "e_fluxo"=> "erro",
                "message"=> "5",
                "response"=> "✅ É verdade! Isso chama muita atenção.\n \n🇧🇷 A pós-carreira dos militares do Brasil envolve uma série de benefícios, incluindo=>\nAposentadoria com o salário integral, assistência médica gratuita em hospitais militares, auxílio funerário, auxílio moradia e descontos em vários serviços!\n             \n🪖 Existem outros fatores atrativos que eu vou te apresentar daqui a 3️⃣ dias. \n             \n📳 Aguarde a mensagem confirmando o Local, Endereço e Horário.\n",
                "created_at"=> null,
                "updated_at"=> null
            ],
            [
                "id"=> "8",
                "tipo"=> "militar",
                "a_fluxo"=> "1.1.6",
                "p_fluxo"=> "1.1.f",
                "e_fluxo"=> "erro",
                "message"=> "6",
                "response"=> "✅ É verdade! Isso chama muita atenção.\n \n🇧🇷 Existem diversas oportunidades de carreira para um militar no Brasil, com diversos programas de especialização e treinamento.\n🎖️ Além de poderem seguir carreira nas áreas de combate, navegação e aviação, os militares podem atuar em áreas de _logística, inteligência, saúde e administração em cada uma das Forças Armadas ( Exército, Marinha e Força Aérea )._\n             \n🪖 Existem outros fatores atrativos que eu vou te apresentar daqui a 3️⃣ dias. \n             \n📳 Aguarde a mensagem confirmando o Local, Endereço e Horário.",
                "created_at"=> null,
                "updated_at"=> null
            ],
            [
                "id"=> "9",
                "tipo"=> "militar",
                "a_fluxo"=> "1.2.f",
                "p_fluxo"=> "1.1.f",
                "e_fluxo"=> "erro",
                "message"=> "*",
                "response"=> "✅ Não se preocupe, nós compreendemos! \n \n💬 Caso mude de ideia, daqui a 3️⃣ dias estarei em sua cidade apresentando *todos* os fatores atrativos dessa carreira! \n \n📳 Aguarde a mensagem confirmando o *Local, Endereço e Horário.*\n",
                "created_at"=> null,
                "updated_at"=> null
            ],
            [
                "id"=> "10",
                "tipo"=> "militar",
                "a_fluxo"=> "1.1.f",
                "p_fluxo"=> "1.1.f",
                "e_fluxo"=> "erro",
                "message"=> "*",
                "response"=> "‼️ Opa! Vi que você tem mais dúvidas, mas no momento não vou estar conseguindo responder! \n\n✅ *Faz assim=>*\n▶️ Deixe tudo anotadinho e no dia do atendimento, pessoalmente, irei tirá-las com você! 😉",
                "created_at"=> null,
                "updated_at"=> null
            ],
            [
                "id"=> "11",
                "tipo"=> "militar",
                "a_fluxo"=> "Ocupado",
                "p_fluxo"=> null,
                "e_fluxo"=> "erro",
                "message"=> "*",
                "response"=> "‼️ Olá! Te peço desculpas, mas no momento não vou conseguir responder!",
                "created_at"=> null,
                "updated_at"=> null
            ],
            [
                "id"=> "12",
                "tipo"=> "militar",
                "a_fluxo"=> null,
                "p_fluxo"=> null,
                "e_fluxo"=> "erro",
                "message"=> "Cadastro realizado com sucesso",
                "response"=> "✅ *Parabéns!!!*\n‼️ Em breve você receberá novas informações. \n📲 Para isso, salve o nosso contato.",
                "created_at"=> null,
                "updated_at"=> null
            ],
            [
                "id"=> "13",
                "tipo"=> "militar",
                "a_fluxo"=> "erro",
                "p_fluxo"=> null,
                "e_fluxo"=> "erro",
                "message"=> "*",
                "response"=> "‼ Para eu conseguir dar continuidade, preciso que você me mande apenas o número da opção desejada.",
                "created_at"=> null,
                "updated_at"=> null
            ]
        ]
        );
    }
}

