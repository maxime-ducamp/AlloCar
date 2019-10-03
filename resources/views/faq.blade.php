@extends('base')

@section('content')
    <main class="mx-auto mt-10 px-4 md:mt-16 leading-normal text-justify md:w-3/4">

        <h1 class="text-blue mb-10 text-center">FAQ</h1>

        <article>
            <h2 class="my-10 text-blue">Qu'est-ce qu'AlloCar ?</h2>
            <p>AlloCar est une application web de covoiturage visant à mettre en relation des particuliers dans le but
            d'effectuer des trajets communs.</p>
            <p>Cette application a avant tout été développée pour promouvoir l'entraide entre les personnes aux revenus
            modestes. Il n'est en effet pas rare que les bénéficiaires de minimas sociaux se voient
                demander de se déplacer, parfois sur de longues distances, afin de participer à des activités d'insertion.
                Ces déplacements ont un coût et ont souvent tendance à fortement peser lorsqu'il est temps de faire les
                comptes.
            </p>
            <p>C'est pourquoi nous mettons à votre disposition un outil qui, nous l'espérons, pourra permettre
                d'avantage d'entraide et de solidarité avec comme cheval de bataille le retour à l'emploi et à
                l'indépendance.
            </p>
        </article>

        <article>
            <h2 class="my-10 text-blue">Comment ça fonctionne ?</h2>
            <p>
                Toute personne souhaitant consulter une liste des trajets disponible est libre de le faire
                sans aucune restriction.
            </p>
            <p>
                Si vous souhaitez proposer un trajet à la communauté ou demander vous-même à participer à un trajet
                existant, il vous faudra <a href="{{ route('register') }}" class="link font-bold">créér un compte</a>.
                Vous serons demandés un nom d'utilisateur et une addresse email valide (plus d'informations sur
                l'utilisation que va faire l'application de vos informations <a href="">ici</a>
            </p>
            <p>
                Rappel: Ne <span class="font-bold italic">jamais</span> communiquer votre mot de passe personnel,
                pas même la modération ou l'administration d'AlloCar.
            </p>
            <p>
                Si vous perdez votre mot de passe Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem dolorem doloribus enim excepturi facilis illo ipsum minima, necessitatibus pariatur quod.
            </p>

            <div>
                <h3 class="my-5 text-blue">Proposer des trajets</h3>
                <p>
                    Une fois votre compte créé, vous aurez la possibilité de
                    <a href="{{ route('journeys.create') }}" class="link font-bold">proposer des trajets</a>.
                </p>
                <p>Diverses informations vous seront demandées telles que les villes de départ et d'arrivée
                ainsi que les horaires auxquelles vous comptez effectuer le trajet.</p>
                <p>
                    Si quelqu'un est intéressé pour participer, il pourra alors en faire la demande. Vous recevrez
                    une notification dans les minutes qui suivent qui vous permettra d'accepter ou de refuser
                    cette requête.
                </p>
                @auth
                    <p>
                        Vous pouvez retrouver la liste des trajets que vous avez proposé
                        <a href="{{ route('profiles.journeys', ['user' => auth()->user()]) }}" class="link font-bold">ici</a>
                    </p>
                @endauth
            </div>

            <div>
                <h3 class="my-5 text-blue">Participer à un trajet</h3>
                <p>
                    Une fois votre créé et si vous avez trouvé un trajet auquel vous aimeriez participer,
                    vous aurez la possibilité d'en faire la demande au conducteur. Celui-ci se verra alors
                    envoyé une notification grâce à laquelle il pourra accepter ou refuser votre participation.
                </p>
                <p>
                    Une notification vous sera alors à votre tour envoyée pour faire connaître sa décision.
                </p>
                @auth
                    <p>
                        Vous pouvez retrouver les trajets sur lesquels vous avez réservé
                        <a href="{{ route('profiles.bookings', ['user' => auth()->user()]) }}" class="link font-bold">ici</a>
                    </p>
                @endauth
            </div>
        </article>

        <article>
            <h2 class="my-10 text-blue">Votre profil</h2>
            <p>
                Lorsque vous disposez d'un compte AlloCar, vous pouvez facilement retrouver votre page de profil
                en cliquant sur votre avatar ou sur l'icône de menu qui se trouvent en haut de l'écran.
            </p>
            <p>
                A partir de cette page vous aurez accés à de nombreuses informations et options telles que la modification
                de votre compte (Par exemple si vous souhaitez changer votre avatar ou votre nom d'utilisateur)
            </p>
            <p>
                Vous y retrouverez également vos notifications.
            </p>
            <p class="font-bold italic text-blue">
                Rappel: les notifications sont au coeur de l'utilisation d'AlloCar, pensez à les visiter
                régulièrement !
            </p>
        </article>

        <article>
            <h2 class="my-10 text-blue">Informations personnelles</h2>
            <p>
                Les données que nous demandons lors de la création d'un compte sur AlloCar
                seront utilisées afin de rendre l'utilisation de l'application plus agréable.
            </p>
            <p>
                Des emails pourront vous être envoyés lorsqu'un événement requérant votre
                attention se produit (Par exemple si vous avez réservé pour un trajet
                et que son conducteur l'annule !)
            </p>
            <p>
                Vous pouvez à tout moment avoir accès et modifier vos données personnelles
                sur votre page de profil.
                C'est également sur cette page que vous pourrez supprimer votre compte.
            </p>
            <p>
                La suppression d'un compte AlloCar est définitive et toutes les données
                que vous nous aviez renseignées sont automatiquement supprimées également.
            </p>
        </article>

        <article class="my-10">
            <p>
                Pour toute demande d'informations, merci de bien vouloir
                contacter le Webmaster à l'adresse: maxime@uponatime.tech
            </p>
        </article>
    </main>
@endsection
