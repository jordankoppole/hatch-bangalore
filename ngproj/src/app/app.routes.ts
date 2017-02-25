import { ProfileComponent } from './profile/profile.component';
import { Routes } from '@angular/router';
import { HomeComponent } from './home';
// import { AboutComponent } from './about';
// import { NoContentComponent } from './no-content';

// import { DataResolver } from './app.resolver';

export const ROUTES: Routes = [
  { path: '',           component: HomeComponent },
  { path: ':username',  component: ProfileComponent },
  // { path: 'about', component: AboutComponent },
  // { path: 'detail', loadChildren: './+detail#DetailModule'},
  // { path: 'barrel', loadChildren: './+barrel#BarrelModule'},
  // { path: '**',    component: NoContentComponent },
];
