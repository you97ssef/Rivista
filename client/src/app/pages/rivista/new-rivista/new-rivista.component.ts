import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { CategoryService } from 'src/app/services/category.service';
import { RivistaService } from 'src/app/services/rivista.service';

@Component({
  selector: 'app-new-rivista',
  templateUrl: './new-rivista.component.html',
  styleUrls: ['./new-rivista.component.scss'],
})
export class NewRivistaComponent implements OnInit {
  rivista: any = {};
  categories: any;

  constructor(
    private categoryService: CategoryService,
    private rivistaService: RivistaService,
    private router: Router
  ) {}

  ngOnInit(): void {
    this.categoryService.all().subscribe((response: any) => {
      this.categories = response.data;
    });
  }
  newRivista = (): void => {
    this.rivistaService.new(this.rivista).subscribe((response: any) => {
      this.router.navigate(['/rivistas', response.data.slug]);
    });
  }
}
