import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { NonAuthGuard } from './guards/non-auth.guard';

// AUTH
import { LoginComponent } from './pages/auth/login/login.component';
import { RegisterComponent } from './pages/auth/register/register.component';
import { ForgotPasswordComponent } from './pages/auth/forgot-password/forgot-password.component';


import { ResetPasswordComponent } from './pages/auth/reset-password/reset-password.component';
import { AuthGuard } from './guards/auth.guard';
import { VerifyEmailComponent } from './pages/auth/verify-email/verify-email.component';

import { HomeComponent } from './pages/home/home.component';
import { CategoryComponent } from './pages/category/category/category.component';
import { RivistaComponent } from './pages/rivista/rivista/rivista.component';
import { RivistasComponent } from './pages/rivista/rivistas/rivistas.component';
import { ProfilesComponent } from './pages/user/profiles/profiles.component';

const routes: Routes = [
  { path: 'login', component: LoginComponent, canActivate: [NonAuthGuard] },
  { path: 'register', component: RegisterComponent, canActivate: [NonAuthGuard] },
  { path: 'forgot-password', component: ForgotPasswordComponent, canActivate: [NonAuthGuard] },
  { path: 'reset-password', component: ResetPasswordComponent, canActivate: [NonAuthGuard] },
  { path: 'verify', component: VerifyEmailComponent, canActivate: [AuthGuard] },
  { path: '', component: HomeComponent },
  { path: 'category/:slug', component: CategoryComponent },
  { path: 'rivistas/:slug', component: RivistaComponent },
  { path: 'rivistas', component: RivistasComponent },
  { path: 'profiles', component: ProfilesComponent },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
