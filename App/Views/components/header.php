
<?php @session_start() ?>

<!DOCTYPE html>
<html lang="en" class="">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- <script src="https://cdn.tailwindcss.com" defer></script> -->
<script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js" defer></script>
<script src="ressources/js/tailwind/tailwind.js"></script>

<link rel="shortcut icon" href="ressources/images/web.svg" />
<title>Genius</title>

<style>
	.none{
		display: none;
	}
	.show{
		display: none;
	}
	.npart1{
		color: #fb3c00;
	}

	.npart2{
		color: #ffb800;
	}

	
.App-logo {
  pointer-events: none;
}

@media (prefers-reduced-motion: no-preference) {
  .App-logo {
    animation: App-logo-spin infinite 8s linear;
  }
}


@keyframes App-logo-spin {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}

</style>



</head>

<header class="py-8 flex justify-between items-center">
		<nav
			class="py-5 border-white-200 px-4 lg:px-6 py-2.5 dark:bg-gray-800 text-xl bg-white shadow-xl p-2 mt-0 fixed w-full z-50 top-0">
			<div
				class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
				<a href="?goto=<?= $this->datacrypt('home') ?>&action=<?= $this->datacrypt('viewHome') ?>" class="flex items-center"> <img
					src="ressources/images/web.svg" class="mr-3 h-6 sm:h-9 App-logo" alt="Flowbite Logo" />
					<span
					class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white name-website">
						<span class="text-cliford">Genius</span> <span class="npart2">Blog</span>   </span>
				</a>

				<div class="flex items-center lg:order-2">
				<div>
				<?php if(isset($_SESSION['Auth'])) {?>
				<div id="profile"
							class="mr-2 l-7 h-10 w-10 hover:ring-4 user cursor-pointer relative ring-blue-700/30 rounded-full bg-cover bg-center bg-[url('ressources/images/user.png')]" > </div>
							
							<div id="profile_menu" class="show">
								<div 
								
								class="mt-3 drop-down  w-48 overflow-hidden bg-white rounded-md shadow absolute" >
								<ul>
									
									<?php if(isset($_SESSION['Auth']['role']) && $_SESSION['Auth']['role']== '0') {?>
									<li class="px-3 py-3 text-sm font-medium flex items-center space-x-2 hover:bg-gray-200 ">
										<a href="?goto=<?= $this->datacrypt('home') ?>&action=<?= $this->datacrypt('sms') ?>" class="flex gap-2">
										<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
											<path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
										</svg>						
										 Messages 
										</a>
									</li>
									<li class="px-3 py-3 text-sm font-medium flex items-center space-x-2 hover:bg-gray-200 ">
										<a href="?goto=<?= $this->datacrypt('home') ?>&action=<?= $this->datacrypt('dash') ?>" class="flex gap-2">
										<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
												<path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
												</svg>
					
										Dashboard 
										</a>
									</li>
									<?php } ?>
									<li class="px-3 py-3 text-sm font-medium flex items-center space-x-2 hover:bg-gray-200 ">
										<a href="?goto=<?= $this->datacrypt('home') ?>&action=<?= $this->datacrypt('comment') ?>" class="flex gap-2">
										<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
										<path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
										</svg>
					
										Commentaires 
										</a>
									</li>

									<li class="px-3 py-3 text-sm font-medium flex items-center space-x-2 hover:bg-gray-200 ">
										<a href="?goto=<?= $this->datacrypt('home') ?>&action=<?= $this->datacrypt('logout') ?>" class="flex gap-2">
										<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
										<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
										</svg>	Logout 
										</a>
									</li>
								
									
								</ul>
							</div>
							</div>
							<?php } ?>
						</div>
					<?php if(!isset($_SESSION['Auth'])) {?>		
					<a href="?goto=<?= $this->datacrypt('home') ?>&action=<?= $this->datacrypt('view-login') ?>"
						class="hidden md:block text-2xl text-gray-800 dark:text-white hover:bg-gray-50  focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">Connexion</a>
						<?php }?>
						<?php if(isset($_SESSION['Auth'])) {?>
							<?php echo $_SESSION['Auth']['pseudo']?>
						<?php } ?>
						<a href="?goto=<?= $this->datacrypt('home') ?>&action=<?= $this->datacrypt('articles') ?>"
						class="ml-3 hidden md:block text-2xl text-white bg-orange-700 hover:bg-orange-400 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-blue-600 dark:hover:bg-orange-700 focus:outline-none dark:focus:ring-blue-800">Découvrir
						nos articles</a>
					<button data-collapse-toggle="mobile-menu-2" type="button"
						class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
						aria-controls="mobile-menu-2" aria-expanded="false">
						<span class="sr-only">Open main menu</span>
						<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
							xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd"
								d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
								clip-rule="evenodd"></path></svg>
						<svg class="hidden w-6 h-6" fill="currentColor"
							viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd"
								d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
								clip-rule="evenodd"></path></svg>
					</button>
				</div>
				<div
					class="ml-10 flex justify-between items-center hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-1"
					id="mobile-menu-2">
					<ul
						class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
						<li><a href="?goto=<?= $this->datacrypt('home') ?>&action=<?= $this->datacrypt('viewHome') ?>"
							class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:text-orange-400  lg:border-0 lg:hover:text-orange-400 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700"
							aria-current="page">Accueil</a></li>
						<li><a href="?goto=<?= $this->datacrypt('home') ?>&action=<?= $this->datacrypt('about') ?>"
							class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:text-orange-400  lg:border-0 lg:hover:text-orange-400 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">A
								propos</a></li>
						<li><a href="?goto=<?= $this->datacrypt('home') ?>&action=<?= $this->datacrypt('contact') ?>"
							class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:text-orange-400  lg:border-0 lg:hover:text-orange-400 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">Contacts</a>
						</li>
						<li><a href="?goto=<?= $this->datacrypt('home') ?>&action=<?= $this->datacrypt('view-login') ?>"
							class="sm:block md:hidden block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:text-orange-400  lg:border-0 lg:hover:text-orange-400 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">Connexion</a>
						</li>
						<li><a href="?goto=<?= $this->datacrypt('home') ?>&action=<?= $this->datacrypt('articles') ?>"
							class="sm:block md:hidden block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:text-orange-400  lg:border-0 lg:hover:text-orange-400 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">Découvrir nos articles</a>
						</li>
					

					</ul>
					
				</div>
				
			</div>

			
		</nav>

		
	</header>
	<script src="ressources/js/toogle_profile.js" defer></script>
