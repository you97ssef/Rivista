import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { FormsModule } from '@angular/forms';
import { HttpClientModule, HTTP_INTERCEPTORS } from '@angular/common/http';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { ToastrModule } from 'ngx-toastr';
import { NgxSpinnerModule } from 'ngx-spinner';

import { RequestInterceptor } from './interceptors/request.interceptor';
import { ErrorInterceptor } from './interceptors/error.interceptor';
import { LoadingInterceptor } from './interceptors/loading.interceptor';

import { AppComponent } from './app.component';

import { NavBarComponent } from './components/nav-bar/nav-bar.component';

import { LoginComponent } from './pages/auth/login/login.component';
import { RegisterComponent } from './pages/auth/register/register.component';
import { ForgotPasswordComponent } from './pages/auth/forgot-password/forgot-password.component';
import { ResetPasswordComponent } from './pages/auth/reset-password/reset-password.component';
import { VerifyEmailComponent } from './pages/auth/verify-email/verify-email.component';

import { HomeComponent } from './pages/home/home.component';
import { ResendVerificationEmailComponent } from './components/resend-verification-email/resend-verification-email.component';
import { CategoryComponent } from './pages/category/category/category.component';
import { RivistaComponent } from './pages/rivista/rivista/rivista.component';
import { NewCommentComponent } from './components/new-comment/new-comment.component';
import { RivistasComponent } from './pages/rivista/rivistas/rivistas.component';
import { RivistaCardComponent } from './components/rivista-card/rivista-card.component';
import { NgxPaginationModule } from 'ngx-pagination';

@NgModule({
  declarations: [
    AppComponent,
    NavBarComponent,
    LoginComponent,
    HomeComponent,
    RegisterComponent,
    ForgotPasswordComponent,
    ResetPasswordComponent,
    VerifyEmailComponent,
    ResendVerificationEmailComponent,
    CategoryComponent,
    RivistaComponent,
    NewCommentComponent,
    RivistasComponent,
    RivistaCardComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    FormsModule,
    HttpClientModule,
    ToastrModule.forRoot(
      {
        positionClass: 'toast-bottom-right',
      }
    ),
    BrowserAnimationsModule,
    NgxSpinnerModule,
    NgxPaginationModule
  ],
  providers: [
    {
      provide: HTTP_INTERCEPTORS,
      useClass: RequestInterceptor,
      multi: true,
    },
    {
      provide: HTTP_INTERCEPTORS,
      useClass: ErrorInterceptor,
      multi: true,
    },
    { 
      provide: HTTP_INTERCEPTORS, 
      useClass: LoadingInterceptor, 
      multi: true 
    },
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
