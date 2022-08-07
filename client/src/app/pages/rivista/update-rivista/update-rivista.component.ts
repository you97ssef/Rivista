import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { CategoryService } from 'src/app/services/category.service';
import { RivistaService } from 'src/app/services/rivista.service';

@Component({
  selector: 'app-update-rivista',
  templateUrl: './update-rivista.component.html',
  styleUrls: ['./update-rivista.component.scss'],
})
export class UpdateRivistaComponent implements OnInit {
  rivista: any = {};
  categories: any;

  constructor(
    private categoryService: CategoryService,
    private rivistaService: RivistaService,
    private router: Router,
    private route: ActivatedRoute
  ) {}

  ngOnInit(): void {
    let slug = this.route.snapshot.paramMap.get('slug');

    if (slug) {
      this.categoryService.all().subscribe((response: any) => {
        this.categories = response.data;
      });

      this.rivistaService.get(slug).subscribe((response: any) => {
        this.rivista = response.data;
      });
    } else {
      this.router.navigateByUrl('/');
    }
  }

  updateRivista = (): void => {
    this.rivistaService.update(this.rivista).subscribe((response: any) => {
      this.router.navigateByUrl('/rivistas/' + response.data.slug);
    });
  };
}
